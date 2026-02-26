<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * DocxExportService
 *
 * Populates a PhpWord template with project data and saves the DOCX file.
 * All template placeholder filling is handled here, keeping the controller
 * free of any PhpWord or file-system concerns.
 *
 * Usage:
 *   $service = new DocxExportService();
 *   $service->generate($project, $id_project);
 */
class DocxExportService
{
    /**
     * Generate and save the DOCX file for the given project.
     *
     * @param  object $project    Project domain object (from get_project_export)
     * @param  int    $id_project Used to name the output file
     * @return string             Saved file path
     * @throws Exception          On PhpWord or filesystem errors
     */
    public function generate($project, int $id_project): string
    {
        require_once APPPATH . 'third_party/vendor/autoload.php';

        $tpl = new \PhpOffice\PhpWord\TemplateProcessor(base_url('export/template.docx'));

        $this->fill_basic_info($tpl, $project);
        $this->fill_members($tpl, $project->get_members());
        $this->fill_planning_lists($tpl, $project);
        $this->fill_research_questions($tpl, $project->get_research_questions());
        $this->fill_databases($tpl, $project->get_databases());
        $this->fill_terms($tpl, $project->get_terms());
        $this->fill_search_strings($tpl, $project->get_search_strings());
        $this->fill_criteria($tpl, $project);
        $this->fill_quality($tpl, $project);
        $this->fill_extraction_questions($tpl, $project->get_questions_extraction());

        $path = './export/P' . $id_project . '.docx';
        $tpl->saveAs($path);

        return $path;
    }

    // -------------------------------------------------------------------------
    // Private fill helpers
    // -------------------------------------------------------------------------

    private function fill_basic_info(\PhpOffice\PhpWord\TemplateProcessor $tpl, $project): void
    {
        $tpl->setValue('title',       $project->get_title());
        $tpl->setValue('description', $project->get_description());
        $tpl->setValue('objectives',  $project->get_objectives());
        $tpl->setValue('strategy',    $project->get_search_strategy());
    }

    private function fill_members(\PhpOffice\PhpWord\TemplateProcessor $tpl, array $members): void
    {
        $tpl->setValue('member',      $this->join_field($members, 'get_name'));
        $tpl->setValue('email',       $this->join_field($members, 'get_email'));
        $tpl->setValue('instituition', $this->join_field($members, 'get_institution'));
    }

    private function fill_planning_lists(\PhpOffice\PhpWord\TemplateProcessor $tpl, $project): void
    {
        $tpl->setValue('domain',     $this->join_values($project->get_domains()));
        $tpl->setValue('language',   $this->join_values($project->get_languages()));
        $tpl->setValue('study_type', $this->join_values($project->get_study_types()));
        $tpl->setValue('keyword',    $this->join_values($project->get_keywords()));
    }

    private function fill_research_questions(\PhpOffice\PhpWord\TemplateProcessor $tpl, array $questions): void
    {
        $tpl->cloneRow('id_rq', count($questions));
        foreach ($questions as $i => $rq) {
            $n = $i + 1;
            $tpl->setValue("id_rq#{$n}",    $rq->get_id());
            $tpl->setValue("rq_desc#{$n}",  $rq->get_description());
        }
    }

    private function fill_databases(\PhpOffice\PhpWord\TemplateProcessor $tpl, array $databases): void
    {
        $tpl->cloneRow('db_name', count($databases));
        foreach ($databases as $i => $db) {
            $n = $i + 1;
            $tpl->setValue("db_name#{$n}", $db->get_name());
            $tpl->setValue("db_link#{$n}", $db->get_link());
        }
    }

    private function fill_terms(\PhpOffice\PhpWord\TemplateProcessor $tpl, array $terms): void
    {
        $tpl->cloneRow('term', count($terms));
        foreach ($terms as $i => $term) {
            $n        = $i + 1;
            $synonyms = implode(' OR ', $term->get_synonyms());
            $tpl->setValue("term#{$n}",    $term->get_description());
            $tpl->setValue("synonym#{$n}", $synonyms);
        }
    }

    private function fill_search_strings(\PhpOffice\PhpWord\TemplateProcessor $tpl, array $strings): void
    {
        $tpl->cloneRow('db_string', count($strings));
        foreach ($strings as $i => $string) {
            $n = $i + 1;
            $tpl->setValue("db_string#{$n}", $string->get_database()->get_name());
            $tpl->setValue("string#{$n}",    $string->get_description());
        }
    }

    private function fill_criteria(\PhpOffice\PhpWord\TemplateProcessor $tpl, $project): void
    {
        $tpl->setValue('inclusion_rule', $project->get_inclusion_rule());
        $inclusion = $project->get_inclusion_criteria();
        $tpl->cloneRow('id_inclusion', count($inclusion));
        foreach ($inclusion as $i => $ic) {
            $n = $i + 1;
            $tpl->setValue("id_inclusion#{$n}", $ic->get_id());
            $tpl->setValue("in_criteria#{$n}",  $ic->get_description());
        }

        $tpl->setValue('exclusion_rule', $project->get_exclusion_rule());
        $exclusion = $project->get_exclusion_criteria();
        $tpl->cloneRow('id_exclusion', count($exclusion));
        foreach ($exclusion as $i => $ec) {
            $n = $i + 1;
            $tpl->setValue("id_exclusion#{$n}", $ec->get_id());
            $tpl->setValue("ex_criteria#{$n}",  $ec->get_description());
        }
    }

    private function fill_quality(\PhpOffice\PhpWord\TemplateProcessor $tpl, $project): void
    {
        $score_min = $project->get_score_min();
        $tpl->setValue('ge_min_to_app', $score_min ? $score_min->get_description() : '');

        $qa_scores = $project->get_quality_scores();
        $tpl->cloneRow('start_in', count($qa_scores));
        foreach ($qa_scores as $i => $score) {
            $n = $i + 1;
            $tpl->setValue("start_in#{$n}", $score->get_start_interval());
            $tpl->setValue("end_in#{$n}",   $score->get_end_interval());
            $tpl->setValue("ge_score#{$n}", $score->get_description());
        }

        $qa_questions = $project->get_questions_quality();
        $tpl->cloneRow('id_qa', count($qa_questions));
        foreach ($qa_questions as $i => $qa) {
            $n      = $i + 1;
            $rules  = $qa->get_scores();
            $scores = implode(";\n", array_map(
                fn($r) => $r->get_score_rule() . ' - ' . $r->get_description(),
                $rules
            )) . ';';

            $minimum = $qa->get_min_to_approve();

            $tpl->setValue("id_qa#{$n}",          $qa->get_id());
            $tpl->setValue("description_qa#{$n}",  $qa->get_description());
            $tpl->setValue("rules_qa#{$n}",        $scores);
            $tpl->setValue("weight#{$n}",          $qa->get_weight());
            $tpl->setValue("min_to_app#{$n}",      $minimum ? $minimum->get_score_rule() : '');
        }
    }

    private function fill_extraction_questions(\PhpOffice\PhpWord\TemplateProcessor $tpl, array $questions): void
    {
        $tpl->cloneRow('id_qe', count($questions));
        foreach ($questions as $i => $qe) {
            $n       = $i + 1;
            $options = implode(";\n", $qe->get_options());

            $tpl->setValue("id_qe#{$n}",          $qe->get_id());
            $tpl->setValue("description_qe#{$n}",  $qe->get_description());
            $tpl->setValue("type#{$n}",            $qe->get_type());
            $tpl->setValue("option#{$n}",          $options);
        }
    }

    // -------------------------------------------------------------------------
    // Utility
    // -------------------------------------------------------------------------

    /**
     * Call $getter on each object in $items and join with ', '.
     */
    private function join_field(array $items, string $getter): string
    {
        return implode(', ', array_map(fn($item) => $item->$getter(), $items));
    }

    /**
     * Join a flat array of scalar values with ', '.
     */
    private function join_values(array $values): string
    {
        return implode(', ', $values);
    }
}
