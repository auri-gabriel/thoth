<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'controllers/Pattern_Controller.php';
require_once APPPATH . 'services/exports/LatexExportService.php';
require_once APPPATH . 'services/exports/BibExportService.php';
require_once APPPATH . 'services/exports/DocxExportService.php';

/**
 * Handles all project export actions: DOCX, LaTeX, and BibTeX.
 *
 * This controller is intentionally thin — it only validates access,
 * fetches data from the model, and delegates rendering to the
 * appropriate export service.
 *
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property CI_Session $session
 * @property Project_Model $Project_Model
 */
class Project_Export_Controller extends Pattern_Controller
{
    /**
     * Export project protocol as a DOCX file
     * URL: /project_export/export_doc
     * POST: id_project
     */
    public function export_doc()
    {
        try {
            $id_project = $this->input->post('id_project');

            $this->validate_level($id_project, [1, 2, 3, 4]);
            $this->load->model('Project_Model');

            $project = $this->Project_Model->get_project_export($id_project);

            $service = new DocxExportService();
            $service->generate($project, $id_project);
        } catch (Exception $e) {
            $this->session->set_flashdata('error', $e->getMessage());
            redirect(base_url());
        }
    }

    /**
     * Export selected sections as a LaTeX document
     * URL: /project_export/export_latex
     * POST: id_project, steps[]
     */
    public function export_latex()
    {
        try {
            $id_project = $this->input->post('id_project');
            $steps      = $this->input->post('steps');

            $this->validate_level($id_project, [1, 3, 4]);
            $this->load->model('Project_Model');

            $project = $this->Project_Model->get_project_export_latex($id_project);

            // Some steps require extra data fetched here to keep services stateless
            $extra = $this->fetch_latex_extra_data($id_project, $steps);

            $service = new LatexExportService();
            echo $service->generate($project, $steps, $extra);
        } catch (Exception $e) {
            $this->session->set_flashdata('error', $e->getMessage());
            redirect(base_url());
        }
    }

    /**
     * Export papers as a BibTeX file
     * URL: /project_export/export_bib
     * POST: id_project, step
     */
    public function export_bib()
    {
        try {
            $id_project = $this->input->post('id_project');
            $step       = $this->input->post('step');

            $this->validate_level($id_project, [1, 2, 3, 4]);
            $this->load->model('Project_Model');

            $papers = $this->Project_Model->export_bib($id_project, $step);

            $service = new BibExportService();
            echo $service->generate($papers);
        } catch (Exception $e) {
            $this->session->set_flashdata('error', $e->getMessage());
            redirect(base_url());
        }
    }

    /**
     * Fetch any per-step extra data that the LaTeX service needs.
     * Keeping model calls in the controller preserves the service's
     * independence from CI's model-loading mechanism.
     */
    private function fetch_latex_extra_data(int $id_project, array $steps): array
    {
        $extra = [];

        foreach ($steps as $step) {
            switch ($step) {
                case 'Import':
                    $extra['num_papers'] = $this->Project_Model->get_num_papers($id_project);
                    break;

                case 'Selection':
                    $extra['cont_papers'] = $this->Project_Model->count_papers_by_status_sel($id_project);
                    break;

                case 'Quality':
                    $extra['papers']    = $this->Project_Model->get_papers_qa_latex($id_project);
                    $extra['qas_score'] = $this->Project_Model->get_evaluation_qa_latex($id_project);
                    break;
            }
        }

        return $extra;
    }
}
