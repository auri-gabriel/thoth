<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * ProjectProtocolService
 *
 * Encapsulates all logic for copying a project's planning protocol
 * (research questions, criteria, quality settings, extraction questions, etc.)
 * into a newly created project.
 *
 * Usage:
 *   $service = new ProjectProtocolService();
 *   $service->copy($source_project_id, $target_project_id);
 */
class ProjectProtocolService
{
    /** @var CI_Controller */
    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
    }

    /**
     * Copy the full planning protocol from $source_id into $target_id.
     */
    public function copy(int $source_id, int $target_id): void
    {
        $this->CI->load->model('Project_Model');
        $source = $this->CI->Project_Model->get_project_planning($source_id);

        $this->copy_overall($source, $target_id);
        $this->copy_research_questions($source, $target_id);
        $this->copy_databases($source, $target_id);
        $this->copy_search_strings($source, $target_id);
        $this->copy_criteria($source, $target_id);
        $this->copy_quality($source, $target_id);
        $this->copy_extraction($source, $target_id);
    }

    // -------------------------------------------------------------------------
    // Private copy helpers — one per domain area
    // -------------------------------------------------------------------------

    private function copy_overall($source, int $target_id): void
    {
        $this->CI->load->model('Overall_Model');

        foreach ($source->get_domains() as $domain) {
            $this->CI->Overall_Model->add_domain($domain, $target_id);
        }

        foreach ($source->get_languages() as $language) {
            $this->CI->Overall_Model->add_language($language, $target_id);
        }

        foreach ($source->get_study_types() as $study_type) {
            $this->CI->Overall_Model->add_study_type($study_type, $target_id);
        }

        foreach ($source->get_keywords() as $keyword) {
            $this->CI->Overall_Model->add_keywords($keyword, $target_id);
        }

        $this->CI->Overall_Model->add_date(
            $source->get_start_date(),
            $source->get_end_date(),
            $target_id
        );
    }

    private function copy_research_questions($source, int $target_id): void
    {
        $this->CI->load->model('Research_Model');

        foreach ($source->get_research_questions() as $rq) {
            $this->CI->Research_Model->add_research_question(
                $rq->get_id(),
                $rq->get_description(),
                $target_id
            );
        }
    }

    private function copy_databases($source, int $target_id): void
    {
        $this->CI->load->model('Database_Model');

        foreach ($source->get_databases() as $db) {
            $this->CI->Database_Model->add_database($db->get_name(), $target_id);
        }
    }

    private function copy_search_strings($source, int $target_id): void
    {
        $this->CI->load->model('Search_String_Model');

        foreach ($source->get_terms() as $term) {
            $this->CI->Search_String_Model->add_term($term->get_description(), $target_id);

            foreach ($term->get_synonyms() as $synonym) {
                $this->CI->Search_String_Model->add_synonym(
                    $synonym,
                    $term->get_description(),
                    $target_id
                );
            }
        }

        $first = true;
        foreach ($source->get_search_strings() as $string) {
            if ($first) {
                $this->CI->Search_String_Model->generate_string_generic(
                    $string->get_description(),
                    $target_id
                );
                $first = false;
            } else {
                $db_id         = $this->CI->Search_String_Model->get_id_database($string->get_database()->get_name());
                $project_db_id = $this->CI->Search_String_Model->get_id_project_database($db_id, $target_id);
                $this->CI->Search_String_Model->generate_string($string->get_description(), $project_db_id);
            }
        }

        $this->CI->Search_String_Model->edit_search_strategy(
            $source->get_search_strategy(),
            $target_id
        );
    }

    private function copy_criteria($source, int $target_id): void
    {
        $this->CI->load->model('Criteria_Model');

        $this->CI->Criteria_Model->edit_inclusion_rule($source->get_inclusion_rule(), $target_id);
        $this->CI->Criteria_Model->edit_exclusion_rule($source->get_exclusion_rule(), $target_id);

        foreach ($source->get_inclusion_criteria() as $ic) {
            $this->CI->Criteria_Model->add_criteria(
                $ic->get_id(),
                $ic->get_description(),
                $ic->get_pre_selected(),
                $target_id,
                'Inclusion'
            );
        }

        foreach ($source->get_exclusion_criteria() as $ec) {
            $this->CI->Criteria_Model->add_criteria(
                $ec->get_id(),
                $ec->get_description(),
                $ec->get_pre_selected(),
                $target_id,
                'Exclusion'
            );
        }
    }

    private function copy_quality($source, int $target_id): void
    {
        $this->CI->load->model('Quality_Model');

        foreach ($source->get_quality_scores() as $score) {
            $this->CI->Quality_Model->add_general_quality_score(
                $score->get_start_interval(),
                $score->get_end_interval(),
                $score->get_description(),
                $target_id
            );
        }

        $this->CI->Quality_Model->edit_min_score(
            $source->get_score_min()->get_description(),
            $target_id
        );

        foreach ($source->get_questions_quality() as $qa) {
            $this->CI->Quality_Model->add_qa(
                $qa->get_id(),
                $qa->get_description(),
                $qa->get_weight(),
                $target_id
            );

            foreach ($qa->get_scores() as $score) {
                $this->CI->Quality_Model->add_score_quality(
                    $score->get_score_rule(),
                    $score->get_score(),
                    $score->get_description(),
                    $target_id,
                    $qa->get_id()
                );
            }

            if ($qa->get_min_to_approve() !== null) {
                $this->CI->Quality_Model->edit_min_score_qa(
                    $qa->get_min_to_approve()->get_score(),
                    $target_id
                );
            }
        }
    }

    private function copy_extraction($source, int $target_id): void
    {
        $this->CI->load->model('Extraction_Model');

        foreach ($source->get_questions_extraction() as $qe) {
            $this->CI->Extraction_Model->add_question_extraction(
                $qe->get_id(),
                $qe->get_description(),
                $qe->get_type(),
                $target_id
            );

            foreach ($qe->get_options() as $option) {
                $this->CI->Extraction_Model->add_option($qe->get_id(), $option, $target_id);
            }
        }
    }
}
