<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Trait Project_Model_Relations
 *
 * Provides all planning-related data getters and the set_full_planning_relations helper.
 * Requires the host class to provide $this->db and status constants.
 *
 * Note: methods that exist in Pattern_Model must not add parameter/return type hints,
 * as PHP 7.4 treats that as an incompatible signature override.
 */
trait Project_Model_Relations
{
    // =========================================================================
    // Shared relation loader for planning/export views
    // =========================================================================

    /**
     * Sets all the planning-related relations on a project object.
     * Used by get_project_planning, get_project_export, get_project_export_latex.
     */
    public function set_full_planning_relations($project, $id_project)
    {
        $project->set_domains($this->get_domains($id_project));
        $project->set_languages($this->get_languages($id_project));
        $project->set_study_types($this->get_study_types($id_project));
        $project->set_keywords($this->get_keywords($id_project));
        $project->set_databases($this->get_databases($id_project));
        $project->set_research_questions($this->get_rqs($id_project));
        $project->set_search_strategy($this->get_search_strategy($id_project));
        $project->set_search_strings($this->get_search_strings($id_project));
        $project->set_terms($this->get_terms($id_project));
        $project->set_inclusion_rule($this->get_inclusion_rule($id_project));
        $project->set_exclusion_rule($this->get_exclusion_rule($id_project));
        $project->set_inclusion_criteria($this->get_criteria($id_project, "Inclusion"));
        $project->set_exclusion_criteria($this->get_criteria($id_project, "Exclusion"));
        $project->set_quality_scores($this->get_general_scores($id_project));
        $project->set_score_min($this->get_min_to_app($id_project));
        $project->set_questions_quality($this->get_qas($id_project));
        $project->set_questions_extraction($this->get_qes($id_project));
    }

    // =========================================================================
    // Data getters
    // =========================================================================

    public function get_domains($id_project)
    {
        $this->db->select('*');
        $this->db->from('domain');
        $this->db->where('id_project', $id_project);

        return array_column($this->db->get()->result(), 'description');
    }

    public function get_languages($id_project)
    {
        $this->db->select('language.description');
        $this->db->from('project_languages');
        $this->db->join('language', 'language.id_language = project_languages.id_language');
        $this->db->where('id_project', $id_project);

        return array_column($this->db->get()->result(), 'description');
    }

    public function get_study_types($id_project)
    {
        $this->db->select('study_type.description');
        $this->db->from('project_study_types');
        $this->db->join('study_type', 'study_type.id_study_type = project_study_types.id_study_type');
        $this->db->where('id_project', $id_project);

        return array_column($this->db->get()->result(), 'description');
    }

    public function get_keywords($id_project)
    {
        $this->db->select('*');
        $this->db->from('keyword');
        $this->db->where('id_project', $id_project);

        return array_column($this->db->get()->result(), 'description');
    }

    public function get_databases($id_project)
    {
        $this->db->select('data_base.*, project_databases.id_project_database');
        $this->db->from('project_databases');
        $this->db->join('data_base', 'data_base.id_database = project_databases.id_database');
        $this->db->where('id_project', $id_project);

        $databases = [];
        foreach ($this->db->get()->result() as $row) {
            $db = new Database();
            $db->set_name($row->name);
            $db->set_link($row->link);
            $databases[] = $db;
        }
        return $databases;
    }

    public function get_rqs($id_project)
    {
        $this->db->select('*');
        $this->db->from('research_question');
        $this->db->where('id_project', $id_project);

        $rqs = [];
        foreach ($this->db->get()->result() as $row) {
            $rq = new Research_Question();
            $rq->set_id($row->id);
            $rq->set_description($row->description);
            $rqs[] = $rq;
        }
        return $rqs;
    }

    public function get_search_strategy($id_project)
    {
        $this->db->select('*');
        $this->db->from('search_strategy');
        $this->db->where('id_project', $id_project);

        $row = $this->db->get()->row();
        return $row ? $row->description : "";
    }

    public function get_search_strings($id_project)
    {
        $sss = [];

        // Generic search strings
        $this->db->select('*');
        $this->db->from('search_string_generics');
        $this->db->where('id_project', $id_project);

        foreach ($this->db->get()->result() as $row) {
            $db = new Database();
            $db->set_name("Generic");
            $db->set_link("#");

            $ss = new Search_String();
            $ss->set_description($row->description);
            $ss->set_database($db);
            $sss[] = $ss;
        }

        // Per-database search strings
        $this->db->select('search_string.description, data_base.name, data_base.link');
        $this->db->from('search_string');
        $this->db->join('project_databases', 'project_databases.id_project_database = search_string.id_project_database');
        $this->db->join('data_base',         'data_base.id_database = project_databases.id_database');
        $this->db->where('id_project', $id_project);

        foreach ($this->db->get()->result() as $row) {
            $db = new Database();
            $db->set_name($row->name);
            $db->set_link($row->link);

            $ss = new Search_String();
            $ss->set_description($row->description);
            $ss->set_database($db);
            $sss[] = $ss;
        }

        return $sss;
    }

    public function get_terms($id_project)
    {
        $this->db->select('*');
        $this->db->from('term');
        $this->db->where('id_project', $id_project);

        $terms = [];
        foreach ($this->db->get()->result() as $row) {
            $term = new Term();
            $term->set_description($row->description);

            $this->db->select('*');
            $this->db->from('synonym');
            $this->db->where('id_term', $row->id_term);
            foreach ($this->db->get()->result() as $synonym) {
                $term->set_synonyms($synonym->description);
            }

            $terms[] = $term;
        }
        return $terms;
    }

    public function get_general_scores($id_project)
    {
        $this->db->select('*');
        $this->db->from('general_score');
        $this->db->where('id_project', $id_project);

        $scores = [];
        foreach ($this->db->get()->result() as $row) {
            $score = new Quality_Score();
            $score->set_description($row->description);
            $score->set_end_interval($row->end);
            $score->set_start_interval($row->start);
            $scores[] = $score;
        }
        return $scores;
    }

    public function get_min_to_app($id_project)
    {
        $this->db->select('description, end, start');
        $this->db->from('min_to_app');
        $this->db->join('general_score', 'min_to_app.id_general_score = general_score.id_general_score');
        $this->db->where('min_to_app.id_project', $id_project);

        $row = $this->db->get()->row();
        if (!$row) {
            return null;
        }

        $score = new Quality_Score();
        $score->set_description($row->description);
        $score->set_end_interval($row->end);
        $score->set_start_interval($row->start);
        return $score;
    }
}
