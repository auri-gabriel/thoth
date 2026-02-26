<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Trait Project_Model_Members
 *
 * Handles all member-related operations: loading, adding, removing,
 * level changes, and reviewer provisioning.
 */
trait Project_Model_Members
{
    // =========================================================================
    // Private — Member loaders
    // =========================================================================

    /**
     * Loads members for a project, optionally filtering by allowed level IDs.
     */
    private function load_members($id_project, array $level_filter = [])
    {
        $this->db->select('name, email, levels.level');
        $this->db->from('members');
        $this->db->join('user',   'user.id_user = members.id_user');
        $this->db->join('levels', 'levels.id_level = members.level');
        $this->db->where('id_project', $id_project);

        if (!empty($level_filter)) {
            $this->db->where_in('members.level', $level_filter);
        }

        $members = [];
        foreach ($this->db->get()->result() as $row) {
            $user = new User();
            $user->set_email($row->email);
            $user->set_level($row->level);
            $user->set_name($row->name);
            $members[] = $user;
        }
        return $members;
    }

    public function get_members($id_project)
    {
        return $this->load_members($id_project);
    }

    public function get_researchers($id_project)
    {
        return $this->load_members($id_project, [self::LEVEL_ADMIN, self::LEVEL_REVIEWER, 4]);
    }

    /** @deprecated Use get_researchers() */
    public function get_researchs($id_project)
    {
        return $this->get_researchers($id_project);
    }

    public function get_members_name_id($id_project)
    {
        $this->db->select('user.id_user, user.name');
        $this->db->from('members');
        $this->db->join('user', 'user.id_user = members.id_user');
        $this->db->where('id_project', $id_project);

        $members = [];
        foreach ($this->db->get()->result() as $row) {
            $members[] = [$row->id_user, $row->name];
        }
        return $members;
    }

    // =========================================================================
    // Public — Members management
    // =========================================================================

    public function add_member($email, $level, $id_project)
    {
        $id_level = $this->get_level_id_by_name($level);
        $id_user  = $this->get_id_name_user($email);

        $this->db->insert('members', [
            'id_user'    => $id_user[0],
            'id_project' => $id_project,
            'level'      => $id_level,
        ]);
        $id_member = $this->db->insert_id();

        if ($id_level == self::LEVEL_ADMIN || $id_level == self::LEVEL_REVIEWER) {
            $this->provision_reviewer_papers($id_member, $id_project);
        }

        return $id_user[1];
    }

    public function delete_member($email, $id_project)
    {
        $this->validate_adm($email, $id_project);

        $user      = $this->get_id_name_user($email);
        $id_member = $this->get_id_member($user[0], $id_project);

        $this->db->where('id_project', $id_project);
        $this->db->where('id_members', $id_member);
        $this->db->delete('members');

        $id_bibs = $this->resolve_bib_ids($id_project);
        if (empty($id_bibs)) {
            return;
        }

        $this->db->select('id_paper');
        $this->db->from('papers');
        $this->db->where_in('id_bib', $id_bibs);
        $paper_ids = array_column($this->db->get()->result(), 'id_paper');

        foreach ($paper_ids as $id_paper) {
            $this->db->select('id_status');
            $this->db->from('papers_selection');
            $this->db->where('id_paper', $id_paper);
            $statuses = array_column($this->db->get()->result(), 'id_status');

            $all_same = count(array_unique($statuses)) === 1;

            if ($all_same) {
                $this->db->where('id_paper', $id_paper);
                $this->db->update('papers', ['status_selection' => $statuses[0]]);
            } else {
                $this->db->where('id_paper', $id_paper);
                $this->db->update('papers', [
                    'status_selection'       => self::STATUS_UNCLASSIFIED,
                    'check_status_selection' => false,
                ]);
            }
        }
    }

    public function edit_level($email, $level, $id_project)
    {
        $this->validate_adm($email, $id_project);

        $id_level  = $this->get_level_id_by_name($level);
        $user      = $this->get_id_name_user($email);
        $id_member = $this->get_id_member($user[0], $id_project);
        $old_level = $this->get_current_member_level($id_member, $id_project);

        if ($id_level === $old_level) {
            return true;
        }

        $this->db->where('id_members', $id_member);
        $this->db->update('members', ['level' => $id_level]);

        $is_reviewer  = $id_level  == self::LEVEL_ADMIN || $id_level  == self::LEVEL_REVIEWER;
        $was_reviewer = $old_level == self::LEVEL_ADMIN || $old_level == self::LEVEL_REVIEWER;

        if ($is_reviewer && !$was_reviewer) {
            $this->provision_reviewer_papers($id_member, $id_project);
        } elseif (!$is_reviewer) {
            $this->db->where('id_member', $id_member)->delete('papers_selection');
            $this->db->where('id_member', $id_member)->delete('papers_qa');
        }

        return true;
    }

    // =========================================================================
    // Private — Member helpers
    // =========================================================================

    private function get_level_id_by_name($level)
    {
        $this->db->select('id_level');
        $this->db->from('levels');
        $this->db->where('level', $level);

        $row = $this->db->get()->row();
        return $row ? (int) $row->id_level : null;
    }

    private function get_current_member_level($id_member, $id_project)
    {
        $this->db->select('id_level');
        $this->db->from('levels');
        $this->db->join('members', 'members.level = levels.id_level');
        $this->db->where('id_members', $id_member);
        $this->db->where('id_project', $id_project);

        $row = $this->db->get()->row();
        return $row ? (int) $row->id_level : null;
    }

    /**
     * Inserts papers_selection and papers_qa rows for a newly-added reviewer member,
     * and resets paper statuses to UNCLASSIFIED.
     */
    private function provision_reviewer_papers($id_member, $id_project)
    {
        $id_bibs   = $this->resolve_bib_ids($id_project);
        $id_papers = !empty($id_bibs) ? $this->get_ids_papers($id_bibs) : [];

        if (empty($id_papers)) {
            return;
        }

        $gen_score        = $this->gen_score_min($id_project);
        $status_selection = [];
        $status_qa        = [];

        foreach ($id_papers as $paper) {
            $status_selection[] = [
                'id_paper'  => $paper,
                'id_member' => $id_member,
                'id_status' => self::STATUS_UNCLASSIFIED,
                'note'      => "",
            ];
            $status_qa[] = [
                'id_paper'     => $paper,
                'id_member'    => $id_member,
                'id_status'    => self::STATUS_UNCLASSIFIED,
                'note'         => "",
                'score'        => 0,
                'id_gen_score' => $gen_score,
            ];
        }

        $this->db->insert_batch('papers_selection', $status_selection);
        $this->db->insert_batch('papers_qa', $status_qa);

        $this->db->where_in('id_paper', $id_papers);
        $this->db->update('papers', [
            'status_selection'       => self::STATUS_UNCLASSIFIED,
            'check_status_selection' => false,
            'status_qa'              => self::STATUS_UNCLASSIFIED,
            'check_qa'               => false,
            'id_gen_score'           => $gen_score,
            'score'                  => 0,
        ]);
    }

    private function validate_adm($email, $id_project)
    {
        $members = $this->get_members($id_project);

        if (count($members) == 1) {
            throw new Exception('The project must contain at least one member and this is the administrator.');
        }

        foreach ($members as $mem) {
            if ($mem->get_level() == "Administrator" && $mem->get_email() != $email) {
                return;
            }
        }

        throw new Exception('The project must contain at least one member and this is the administrator.');
    }
}
