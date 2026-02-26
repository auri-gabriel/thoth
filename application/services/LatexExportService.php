<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * LatexExportService
 *
 * Builds a LaTeX document string from a project object.
 * Each section (Planning, Import, Selection, Quality) is handled
 * by its own private method to keep the logic readable and isolated.
 *
 * Usage:
 *   $service = new LatexExportService();
 *   echo $service->generate($project, $steps, $extra_data);
 */
class LatexExportService
{
    /**
     * Generate a complete LaTeX document.
     *
     * @param  object   $project   Project domain object
     * @param  string[] $steps     Sections to include: 'Planning', 'Import', 'Selection', 'Quality'
     * @param  array    $extra     Extra step-specific data fetched by the controller:
     *                               'num_papers'  => for Import
     *                               'cont_papers' => for Selection
     *                               'papers'      => for Quality
     *                               'qas_score'   => for Quality
     * @return string
     */
    public function generate($project, array $steps, array $extra = []): string
    {
        $out  = $this->build_preamble($project);
        $out .= $this->build_document_open($project);

        foreach ($steps as $step) {
            switch ($step) {
                case 'Planning':
                    $out .= $this->build_planning_section($project);
                    break;
                case 'Import':
                    $out .= $this->build_import_section($project, $extra['num_papers'] ?? []);
                    break;
                case 'Selection':
                    $out .= $this->build_selection_section($extra['cont_papers'] ?? []);
                    break;
                case 'Quality':
                    $out .= $this->build_quality_section(
                        $project,
                        $extra['papers']    ?? [],
                        $extra['qas_score'] ?? []
                    );
                    break;
            }
        }

        $out .= "\\bibliography{Bib}\n";
        $out .= "\\end{document}\n";

        return $out;
    }

    // -------------------------------------------------------------------------
    // Document structure
    // -------------------------------------------------------------------------

    private function build_preamble($project): string
    {
        $members = implode(',\\\ ', array_map(
            fn($m) => $m->get_name() . ' (' . $m->get_email() . ')',
            $project->get_members()
        ));

        $out  = "\\documentclass [11pt]{article}\n";
        $out .= "\\usepackage[utf8]{inputenc}\n";
        $out .= "\\usepackage{graphicx}\n";
        $out .= "\\usepackage{booktabs}\n";
        $out .= "\\usepackage{float}\n";
        $out .= "\\usepackage[alf]{abntex2cite}\n";
        $out .= "\\usepackage[brazilian,hyperpageref]{backref}\n\n";

        $out .= "\\renewcommand{\\backrefpagesname}{Citado na(s) página(s):~}\n";
        $out .= "\\renewcommand{\\backref}{}\n";
        $out .= "\\renewcommand*{\\backrefalt}[4]{\n";
        $out .= "\\ifcase #1 %\n";
        $out .= "Nenhuma citação no texto.%\n";
        $out .= "\\or\n";
        $out .= "Citado na página #2.%\n";
        $out .= "\\else\n";
        $out .= "Citado #1 vezes nas páginas #2.%\n";
        $out .= "\\fi}%\n\n";

        $out .= "\\title{" . $project->get_title() . "}\n";
        $out .= "\\author{" . $members . "}\n\n";

        return $out;
    }

    private function build_document_open($project): string
    {
        $out  = "\\begin{document}\n";
        $out .= "\\maketitle\n\n";
        $out .= "\\begin{abstract}\n";
        $out .= "\\end{abstract}\n\n";

        return $out;
    }

    // -------------------------------------------------------------------------
    // Section: Planning
    // -------------------------------------------------------------------------

    private function build_planning_section($project): string
    {
        $out  = "\\section{Planning}\n\n";
        $out .= "\\subsection{Description}\n" . $project->get_description() . "\n\n";
        $out .= "\\subsection{Objectives}\n" . $project->get_objectives() . "\n\n";
        $out .= $this->build_itemize_section('Domains', $project->get_domains());
        $out .= $this->build_itemize_section('Languages', $project->get_languages());
        $out .= $this->build_itemize_section('Studies Types', $project->get_study_types());
        $out .= $this->build_keywords_subsection($project->get_keywords());
        $out .= $this->build_research_questions_subsection($project->get_research_questions());
        $out .= $this->build_databases_table($project->get_databases());
        $out .= $this->build_terms_table($project->get_terms());
        $out .= $this->build_search_strings_subsection($project->get_search_strings());
        $out .= "\\subsection{Search Strategy}\n" . $project->get_search_strategy() . "\n\n";
        $out .= $this->build_criteria_subsection($project);
        $out .= $this->build_general_scores_subsection($project);
        $out .= $this->build_quality_questions_subsection($project);
        $out .= $this->build_extraction_questions_subsection($project);

        return $out;
    }

    private function build_itemize_section(string $title, array $items): string
    {
        $out  = "\\subsection{" . $title . "}\n";
        $out .= "\\begin{itemize}\n";
        foreach ($items as $item) {
            $out .= "\t\\item " . $item . ";\n";
        }
        $out .= "\\end{itemize}\n\n";

        return $out;
    }

    private function build_keywords_subsection(array $keywords): string
    {
        $out  = "\\subsection{Keywords}\n";
        $out .= implode('.=', $keywords) . ".\n\n";

        return $out;
    }

    private function build_research_questions_subsection(array $questions): string
    {
        $out  = "\\subsection{Research Questions}\n";
        $out .= "\\begin{itemize}\n";
        foreach ($questions as $rq) {
            $out .= "\t\\item \\textbf{" . $rq->get_id() . "} " . $rq->get_description() . ";\n";
        }
        $out .= "\\end{itemize}\n\n";

        return $out;
    }

    private function build_databases_table(array $databases): string
    {
        $out  = "\\subsection{Databases}\n";
        $out .= "\\begin{table}[!htb]\n";
        $out .= "\\caption[Databases used at work]{Databases used at work.}\n";
        $out .= "\\label{tab:databases}\n\\centering\n";
        $out .= "\\begin{tabular}{@{}ll@{}}\\toprule\n";
        $out .= "\\textbf{Database} & \\textbf{Link} \\\\ \\midrule\n";

        $last = array_key_last($databases);
        foreach ($databases as $k => $db) {
            $suffix = ($k === $last) ? " \\\\ \\bottomrule" : " \\\\";
            $out   .= $db->get_name() . " & " . $db->get_link() . $suffix . "\n";
        }

        $out .= "\\end{tabular}\n\\end{table}\n\n";

        return $out;
    }

    private function build_terms_table(array $terms): string
    {
        $out  = "\\subsection{Terms and Synonyms}\n";
        $out .= "\\begin{table}[H]\n";
        $out .= "\\caption[Terms and Synonyms used at work]{Terms and Synonyms used at work.}\n";
        $out .= "\\label{tab:terms}\n\\centering\n";
        $out .= "\\begin{tabular}{@{}ll@{}}\\toprule\n";
        $out .= "\\textbf{Term} & \\textbf{Synonyms} \\\\ \\midrule\n";

        foreach ($terms as $term) {
            $synonyms  = "\\begin{tabular}[c]{@{}l@{}}";
            $synonyms .= implode('\\\\', $term->get_synonyms());
            $synonyms .= "\\end{tabular}";
            $out .= $term->get_description() . " & " . $synonyms . " \\\\ \\bottomrule\n";
        }

        $out .= "\\end{tabular}\n\\end{table}\n\n";

        return $out;
    }

    private function build_search_strings_subsection(array $strings): string
    {
        $out  = "\\subsection{Search Strings}\n";
        $out .= "\\begin{itemize}\n";
        foreach ($strings as $string) {
            $out .= "\\item \\textbf{" . $string->get_database()->get_name() . ": }" . $string->get_description() . ";\n";
        }
        $out .= "\\end{itemize}\n\n";

        return $out;
    }

    private function build_criteria_subsection($project): string
    {
        $out  = "\\subsection{Inclusion and Exclusion Criteria}\n";
        $out .= "Inclusion Rule: " . $project->get_inclusion_rule() . "\n\n";
        $out .= "\\begin{itemize}\n";
        foreach ($project->get_inclusion_criteria() as $ic) {
            $out .= "\\item \\textbf{" . $ic->get_id() . ": }" . $ic->get_description() . ";\n";
        }
        $out .= "\\end{itemize}\n\n";

        $out .= "Exclusion Rule: " . $project->get_exclusion_rule() . "\n\n";
        $out .= "\\begin{itemize}\n";
        foreach ($project->get_exclusion_criteria() as $ec) {
            $out .= "\\item \\textbf{" . $ec->get_id() . ": }" . $ec->get_description() . ";\n";
        }
        $out .= "\\end{itemize}\n\n";

        return $out;
    }

    private function build_general_scores_subsection($project): string
    {
        $score_min = $project->get_score_min();
        $min_label = is_null($score_min)
            ? "Score Minimum to Approve: Not minimum.\n"
            : "Score Minimum to Approve: " . $score_min->get_description() . ".\n";

        $out  = "\\subsection{General Scores}\n" . $min_label . "\n";
        $out .= "\\begin{table}[!htb]\n";
        $out .= "\\caption[General Scores used at work]{General Score used at work.}\n";
        $out .= "\\label{tab:genscores}\n\\centering\n";
        $out .= "\\begin{tabular}{@{}lll@{}}\\toprule\n";
        $out .= "\\textbf{Start Interval} & \\textbf{End Interval} & \\textbf{Description} \\\\ \\midrule\n";

        foreach ($project->get_quality_scores() as $score) {
            $out .= $score->get_start_interval() . " & " . $score->get_end_interval() . " & " . $score->get_description() . " \\\\ \\bottomrule\n";
        }

        $out .= "\\end{tabular}\n\\end{table}\n\n";

        return $out;
    }

    private function build_quality_questions_subsection($project): string
    {
        $out  = "\\subsection{Quality Questions}\n";
        $out .= "\\begin{itemize}\n";
        foreach ($project->get_questions_quality() as $qa) {
            $out .= "\\item \\textbf{" . $qa->get_id() . ": } " . $qa->get_description() . ";\n";
        }
        $out .= "\\end{itemize}\n\n";

        $out .= "\\begin{table}[!htb]\n";
        $out .= "\\caption[Quality Questions used at work]{Quality Questions used at work.}\n";
        $out .= "\\label{tab:qa}\n\\centering\n";
        $out .= "\\begin{tabular}{@{}llll@{}}\\toprule\n";
        $out .= "\\textbf{ID} & \\textbf{Rules} & \\textbf{Weight} & \\textbf{\\begin{tabular}[c]{@{}l@{}}Minimum\\\\ to\\\\ Approve\\end{tabular}} \\\\ \\midrule\n";

        foreach ($project->get_questions_quality() as $qa) {
            $scores  = "\\begin{tabular}[c]{@{}l@{}}";
            $scores .= implode('\\\\', array_map(fn($s) => $s->get_score_rule(), $qa->get_scores()));
            $scores .= "\\end{tabular}";

            $minimum = $qa->get_min_to_approve();
            $min     = ($minimum !== null) ? $minimum->get_score_rule() : 'Not exist minimum';

            $out .= $qa->get_id() . " & " . $scores . " & " . $qa->get_weight() . " & " . $min . " \\\\ \\bottomrule\n";
        }

        $out .= "\\end{tabular}\n\\end{table}\n\n";

        return $out;
    }

    private function build_extraction_questions_subsection($project): string
    {
        $out  = "\\subsection{Extraction Questions}\n";
        $out .= "\\begin{itemize}\n";
        foreach ($project->get_questions_extraction() as $qe) {
            $out .= "\\item \\textbf{" . $qe->get_id() . ": } " . $qe->get_description() . ";\n";
        }
        $out .= "\\end{itemize}\n\n";

        $out .= "\\begin{table}[!htb]\n";
        $out .= "\\caption[Extraction Questions used at work]{Extraction Questions used at work.}\n";
        $out .= "\\label{tab:qe}\n\\centering\n";
        $out .= "\\begin{tabular}{@{}lll@{}}\\toprule\n";
        $out .= "\\textbf{ID} & \\textbf{Type} & \\textbf{Options} \\\\ \\midrule\n";

        foreach ($project->get_questions_extraction() as $qe) {
            $ops  = "\\begin{tabular}[c]{@{}l@{}}";
            $ops .= implode('\\\\', $qe->get_options());
            $ops .= "\\end{tabular}";

            $out .= $qe->get_id() . " & " . $qe->get_type() . " & " . $ops . " \\\\ \\bottomrule\n";
        }

        $out .= "\\end{tabular}\n\\end{table}\n\n";

        return $out;
    }

    // -------------------------------------------------------------------------
    // Section: Import
    // -------------------------------------------------------------------------

    private function build_import_section($project, array $num_papers): string
    {
        $out  = "\\section{Import Studies}\n\n";
        $out .= "\\subsection{Studies per Database}\n";
        $out .= "\\begin{table}[!htb]\n";
        $out .= "\\caption[Studies per Database]{Studies per Database.}\n";
        $out .= "\\label{tab:studiesDatabases}\n\\centering\n";
        $out .= "\\begin{tabular}{@{}ll@{}}\\toprule\n";
        $out .= "\\textbf{Database} & \\textbf{Number of Studies} \\\\ \\midrule\n";

        foreach ($project->get_databases() as $db) {
            $count = $num_papers[$db->get_name()] ?? 0;
            $out  .= $db->get_name() . " & " . $count . " \\\\\n";
        }

        $out .= "\\end{tabular}\n\\end{table}\n\n";

        return $out;
    }

    // -------------------------------------------------------------------------
    // Section: Selection
    // -------------------------------------------------------------------------

    private function build_selection_section(array $cont_papers): string
    {
        $status_labels = [
            1 => 'Accepted',
            2 => 'Rejected',
            3 => 'Unclassified',
            4 => 'Duplicate',
            5 => 'Removed',
            6 => 'Total',
        ];

        $out  = "\\section{Selection Studies}\n\n";
        $out .= "\\subsection{Studies per Status Selection}\n";
        $out .= "\\begin{table}[!htb]\n";
        $out .= "\\caption[Studies per Status Selection]{Studies per Status Selection.}\n";
        $out .= "\\label{tab:studiesSelection}\n\\centering\n";
        $out .= "\\begin{tabular}{@{}ll@{}}\\toprule\n";
        $out .= "\\textbf{Status} & \\textbf{Number of Studies} \\\\ \\midrule\n";

        foreach ($cont_papers as $key => $value) {
            $label = $status_labels[$key] ?? '';
            $out  .= $label . " & " . $value . " \\\\\n";
        }

        $out .= "\\end{tabular}\n\\end{table}\n\n";

        return $out;
    }

    // -------------------------------------------------------------------------
    // Section: Quality
    // -------------------------------------------------------------------------

    private function build_quality_section($project, array $papers, array $qas_score): string
    {
        $qa_questions = $project->get_questions_quality();
        $col_count    = count($qa_questions) + 4;
        $col_spec     = str_repeat('l', $col_count);

        $header_ids = implode(' &', array_map(
            fn($qa) => "\\textbf{" . $qa->get_id() . "}",
            $qa_questions
        ));

        $out  = "\\section{Quality Assessment}\n\n";
        $out .= "\\subsection{Quality Assessment}\n";
        $out .= "\\begin{table}[!htb]\n";
        $out .= "\\caption[Quality Assessment]{Quality Assessment.}\n";
        $out .= "\\label{tab:studiesQuality}\n\\centering\n";
        $out .= "\\begin{tabular}{@{}" . $col_spec . "@{}}\\toprule\n";
        $out .= "\\textbf{ID} & " . $header_ids . " & \\textbf{General Score} & \\textbf{Score} & \\textbf{Status} \\\\ \\midrule\n";

        $status_labels = [1 => 'Accepted', 2 => 'Rejected', 4 => 'Removed'];

        foreach ($papers as $paper) {
            $out .= "\\citeonline{" . $paper->get_id() . "} &";

            $paper_scores = $qas_score[$paper->get_id()] ?? [];
            foreach ($qa_questions as $qa) {
                $out .= ($paper_scores[$qa->get_id()] ?? '') . " &";
            }

            $status = $status_labels[$paper->get_status_quality()] ?? 'Unclassified';
            $out   .= $paper->get_rule_quality() . " & " . $paper->get_score() . " & " . $status . " \\\\\n";
        }

        $out .= "\\end{tabular}\n\\end{table}\n\n";

        return $out;
    }
}
