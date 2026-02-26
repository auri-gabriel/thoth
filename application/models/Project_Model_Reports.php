<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Trait Project_Model_Reports
 *
 * Provides all chart/reporting data methods:
 * papers by database, by selection status, by QA status,
 * PRISMA funnel steps, activity log, score distribution,
 * and extraction question aggregations.
 */
trait Project_Model_Reports
{
    public function get_papers_database($id_project)
    {
        $id_bibs = $this->resolve_bib_ids($id_project);
        if (empty($id_bibs)) {
            return [];
        }

        $this->db->select('name, COUNT(*) as count');
        $this->db->from('papers');
        $this->db->join('data_base', 'data_base.id_database = papers.data_base');
        $this->db->group_by('data_base');
        $this->db->where_in('id_bib', $id_bibs);

        $data = [];
        foreach ($this->db->get()->result() as $row) {
            $data[] = ['name' => $row->name, 'y' => (int) $row->count];
        }
        return $data;
    }

    public function get_papers_status_selection($id_project)
    {
        $id_bibs = $this->resolve_bib_ids($id_project);
        if (empty($id_bibs)) {
            return [];
        }

        $this->db->select('status_selection.description, COUNT(*) as count');
        $this->db->from('papers');
        $this->db->join('status_selection', 'papers.status_selection = status_selection.id_status');
        $this->db->group_by('papers.status_selection');
        $this->db->where_in('papers.id_bib', $id_bibs);

        $color_map = [
            'Accepted'     => '#90ed7d',
            'Rejected'     => '#f45b5b',
            'Unclassified' => '#434348',
            'Duplicate'    => '#e4d354',
            'Removed'      => '#7cb5ec',
        ];

        $data = [];
        foreach ($this->db->get()->result() as $row) {
            $entry = ['name' => $row->description, 'y' => (int) $row->count];
            if (isset($color_map[$row->description])) {
                $entry['color'] = $color_map[$row->description];
            }
            $data[] = $entry;
        }
        return $data;
    }

    public function get_papers_status_quality($id_project)
    {
        $id_bibs = $this->resolve_bib_ids($id_project);
        if (empty($id_bibs)) {
            return [];
        }

        $this->db->select('status_qa.status, COUNT(*) as count');
        $this->db->from('papers');
        $this->db->join('status_qa', 'papers.status_qa = status_qa.id_status');
        $this->db->group_by('papers.status_qa');
        $this->db->where_in('papers.id_bib', $id_bibs);
        $this->db->where('status_selection', self::STATUS_ACCEPTED);

        $color_map = [
            'Accepted'     => '#90ed7d',
            'Rejected'     => '#f45b5b',
            'Unclassified' => '#434348',
            'Removed'      => '#7cb5ec',
        ];

        $data = [];
        foreach ($this->db->get()->result() as $row) {
            $entry = ['name' => $row->status, 'y' => (int) $row->count];
            if (isset($color_map[$row->status])) {
                $entry['color'] = $color_map[$row->status];
            }
            $data[] = $entry;
        }
        return $data;
    }

    public function get_papers_step($id_project)
    {
        $id_bibs = $this->resolve_bib_ids($id_project);
        $data    = [];

        if (!empty($id_bibs)) {
            $step_queries = [
                ['label' => 'Imported Studies', 'where' => null,                                    'where_not_in' => null],
                ['label' => 'Not Duplicate',    'where' => null,                                    'where_not_in' => ['status_selection', [self::STATUS_DUPLICATE]]],
                ['label' => 'Status Selection', 'where' => ['status_selection' => self::STATUS_ACCEPTED], 'where_not_in' => null],
                ['label' => 'Status Quality',   'where' => ['status_qa'        => self::STATUS_ACCEPTED], 'where_not_in' => null],
                ['label' => 'Status Extraction','where' => ['status_extraction' => self::STATUS_ACCEPTED], 'where_not_in' => null],
            ];

            foreach ($step_queries as $step) {
                $this->db->select('COUNT(*) as count');
                $this->db->from('papers');
                $this->db->where_in('id_bib', $id_bibs);

                if ($step['where']) {
                    foreach ($step['where'] as $col => $val) {
                        $this->db->where($col, $val);
                    }
                }
                if ($step['where_not_in']) {
                    $this->db->where_not_in($step['where_not_in'][0], $step['where_not_in'][1]);
                }

                $row    = $this->db->get()->row();
                $data[] = [$step['label'], (int) ($row->count ?? 0)];
            }
        }

        return ['name' => 'Studies', 'data' => $data];
    }

    public function get_act_project($id_project)
    {
        $mems     = $this->get_members_name_id($id_project);
        $days     = [];

        $this->db->select('CAST(time as date) as day, COUNT(*) as count');
        $this->db->from('activity_log');
        $this->db->group_by('day');
        $this->db->where('id_project', $id_project);

        $project_data = [];
        foreach ($this->db->get()->result() as $row) {
            $project_data[] = (int) $row->count;
            $days[]         = $row->day;
        }

        $series   = [];
        $series[] = ['name' => 'Project', 'data' => $project_data];

        foreach ($mems as $mem) {
            $mem_data = [];
            foreach ($days as $day) {
                $this->db->select('COUNT(*) as count');
                $this->db->from('activity_log');
                $this->db->where('id_project', $id_project);
                $this->db->where('id_user', $mem[0]);
                $this->db->where('CAST(time as date) =', $day);
                $query = $this->db->get();

                $mem_data[] = $query->num_rows() > 0
                    ? (int) $query->row()->count
                    : null;
            }
            $series[] = ['name' => $mem[1], 'data' => $mem_data];
        }

        return ['categories' => $days, 'series' => $series];
    }

    public function get_papers_score_quality($id_project)
    {
        $id_bibs = $this->resolve_bib_ids($id_project);
        if (empty($id_bibs)) {
            return [];
        }

        $this->db->select('general_score.description as desc, COUNT(*) as count');
        $this->db->from('papers');
        $this->db->join('general_score', 'general_score.id_general_score = papers.id_gen_score');
        $this->db->group_by('papers.id_gen_score');
        $this->db->where_in('papers.id_bib', $id_bibs);
        $this->db->where('status_selection', self::STATUS_ACCEPTED);

        $data = [];
        foreach ($this->db->get()->result() as $row) {
            $data[] = ['name' => $row->desc, 'y' => (int) $row->count];
        }
        return $data;
    }

    // =========================================================================
    // Public — Extraction question aggregations
    // =========================================================================

    public function get_id_qe($id, $id_project)
    {
        $this->db->select('id_de');
        $this->db->from('question_extraction');
        $this->db->where('id', $id);
        $this->db->where('id_project', $id_project);

        $row = $this->db->get()->row();
        return $row ? (int) $row->id_de : null;
    }

    public function get_data_qes_select($id_project)
    {
        $data = [];
        foreach ($this->get_qes($id_project) as $qe) {
            if ($qe->get_type() !== "Pick One List") {
                continue;
            }

            $id_qe = $this->get_id_qe($qe->get_id(), $id_project);

            $this->db->select('options_extraction.description, COUNT(*) as count');
            $this->db->from('evaluation_ex_op');
            $this->db->join('options_extraction', 'options_extraction.id_option = evaluation_ex_op.id_option');
            $this->db->group_by('evaluation_ex_op.id_option');
            $this->db->where('evaluation_ex_op.id_qe', $id_qe);

            $data2 = [];
            foreach ($this->db->get()->result() as $row) {
                $data2[] = ['name' => $row->description, 'y' => (int) $row->count];
            }
            $data[] = ['id' => $qe->get_id(), 'type' => $qe->get_type(), 'data' => $data2];
        }
        return $data;
    }

    public function get_data_qes_multiple($id_project)
    {
        $id_bibs   = $this->resolve_bib_ids($id_project);
        $id_papers = !empty($id_bibs) ? $this->get_ids_papers_chars($id_bibs) : [];
        $qes       = !empty($id_papers) ? $this->get_qes($id_project) : [];

        $data = [];
        foreach ($qes as $qe) {
            if ($qe->get_type() !== "Multiple Choice List") {
                continue;
            }

            $id_qe = $this->get_id_qe($qe->get_id(), $id_project);
            $data2 = [];

            foreach ($qe->get_options() as $op) {
                $id_option         = $this->get_id_option($op, $id_qe);
                $data2[$id_option] = ['sets' => [$op], 'value' => 0];
            }

            foreach ($id_papers as $id_paper) {
                $sets = [];
                $id   = "";

                $this->db->select('evaluation_ex_op.id_option, options_extraction.description');
                $this->db->from('evaluation_ex_op');
                $this->db->join('options_extraction', 'options_extraction.id_option = evaluation_ex_op.id_option');
                $this->db->where('id_paper', $id_paper);
                $this->db->where('id_qe', $id_qe);
                $this->db->order_by('evaluation_ex_op.id_option', 'asc');

                $cont = 0;
                foreach ($this->db->get()->result() as $row) {
                    $sets[]                            = $row->description;
                    $id                               .= $row->id_option;
                    $data2[$row->id_option]['value']  += 1;
                    $cont++;
                }

                $data2[$id]['sets'] = $sets;
                if ($cont > 1) {
                    $data2[$id]['value'] = ($data2[$id]['value'] ?? 0) + 1;
                }
            }

            $data[] = ['id' => $qe->get_id(), 'type' => $qe->get_type(), 'data' => array_values($data2)];
        }
        return $data;
    }
}
