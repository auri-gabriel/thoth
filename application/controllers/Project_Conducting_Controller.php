<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'controllers/Pattern_Controller.php';

/**
 * Handles AJAX requests for each tab on the Conducting page.
 *
 * Each method validates access, fetches only the data its tab needs,
 * and renders the corresponding partial view.
 *
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property Project_Model $Project_Model
 */
class Project_Conducting_Controller extends Pattern_Controller
{
	private function load_project_model_for_tab(int $id): void
	{
		$this->validate_level($id, [1, 2, 3, 4]);
		$this->load->model('Project_Model');
	}

	private function render_ajax_error(Exception $e): void
	{
		http_response_code(403);
		echo '<div class="text-danger">' . htmlspecialchars($e->getMessage()) . '</div>';
	}

	/**
	 * AJAX endpoint — Import tab
	 * URL: /project_conducting/conducting_import?id={id}
	 */
	public function conducting_import_studies()
	{
		$id = $this->input->get('id');
		try {
			$this->load_project_model_for_tab($id);

			$data['project']    = $this->Project_Model->get_project_selection($id);
			$data['bib']        = $this->Project_Model->get_name_bibs($id);
			$data['num_papers'] = $this->Project_Model->get_num_papers($id);

			$this->render(
				'pages/project/conducting/tabs/tab_import_studies',
				['data' => $data]
			);
		} catch (Exception $e) {
			$this->render_ajax_error($e);
		}
	}

	/**
	 * AJAX endpoint — Study Selection tab
	 * URL: /project_conducting/conducting_selection?id={id}
	 */
	public function conducting_study_selection()
	{
		$id = $this->input->get('id');
		try {
			$this->load_project_model_for_tab($id);

			$data['project']      = $this->Project_Model->get_project_selection($id);
			$data['count_papers'] = $this->Project_Model->count_papers_sel_by_user($id);
			$data['criterias']    = $this->Project_Model->get_evaluation_selection($id);

			$this->render(
				'pages/project/conducting/tabs/tab_study_selection',
				['data' => $data]
			);
		} catch (Exception $e) {
			$this->render_ajax_error($e);
		}
	}

	/**
	 * AJAX endpoint — Quality Assessment tab
	 * URL: /project_conducting/conducting_quality?id={id}
	 */
	public function conducting_quality_assessment()
	{
		$id = $this->input->get('id');
		try {
			$this->load_project_model_for_tab($id);

			$data['project_quality']  = $this->Project_Model->get_project_quality($id);
			$data['count_papers_qa']  = $this->Project_Model->count_papers_qa_by_user($id);
			$data['qas_score']        = $this->Project_Model->get_evaluation_qa($id);

			$this->render(
				'pages/project/conducting/tabs/tab_quality_assessment',
				['data' => $data]
			);
		} catch (Exception $e) {
			$this->render_ajax_error($e);
		}
	}

	/**
	 * AJAX endpoint — Data Extraction tab
	 * URL: /project_conducting/conducting_extraction?id={id}
	 */
	public function conducting_data_extraction()
	{
		$id = $this->input->get('id');
		try {
			$this->load_project_model_for_tab($id);

			$data['project']      = $this->Project_Model->get_project_extraction($id);
			$data['count_papers'] = $this->Project_Model->count_papers_extraction($id);

			$this->render(
				'pages/project/conducting/tabs/tab_data_extraction',
				['data' => $data]
			);
		} catch (Exception $e) {
			$this->render_ajax_error($e);
		}
	}
}
