<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'controllers/Pattern_Controller.php';

/**
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property CI_Session $session
 * @property Project_Model $Project_Model
 * @property Selection_Model $Selection_Model
 * @property Quality_Model $Quality_Model
 * @property User_Model $User_Model
 */
class Project_Controller extends Pattern_Controller
{
	/**
	 * Project overview page
	 * URL: /project/open/{id}
	 */
	public function open($id)
	{
		try {
			$this->validate_level($id, [1, 2, 3, 4]);
			$this->load->model('Project_Model');

			$data['project'] = $this->Project_Model->get_project_overview($id);
			$data['logs']    = $this->Project_Model->get_logs_project($id);

			$this->load_views('pages/project/project', $data);
		} catch (Exception $e) {
			$this->session->set_flashdata('error', $e->getMessage());
			redirect(base_url());
		}
	}

	/**
	 * Planning page
	 * URL: /project/planning/{id}
	 */
	public function planning($id)
	{
		try {
			$this->validate_level($id, [1, 2, 3, 4]);
			$this->load->model('Project_Model');

			$data['project']        = $this->Project_Model->get_project_planning($id);
			$data['languages']      = $this->Project_Model->get_all_languages();
			$data['study_types']    = $this->Project_Model->get_all_study_types();
			$data['databases']      = $this->Project_Model->get_all_databases();
			$data['rules']          = $this->Project_Model->get_all_rules();
			$data['question_types'] = $this->Project_Model->get_all_types();

			$this->load_views('pages/project/planning/planning', $data);
		} catch (Exception $e) {
			$this->session->set_flashdata('error', $e->getMessage());
			redirect(base_url());
		}
	}

	/**
	 * Conducting page
	 * Note: the conducting view includes all tab partials server-side,
	 * so all tab data must be fetched here upfront.
	 * URL: /project/conducting/{id}
	 */
	public function conducting($id)
	{
		try {
			$this->validate_level($id, [1, 2, 3, 4]);
			$this->load->model('Project_Model');

			// Shared / Import tab
			$data['project']     = $this->Project_Model->get_project_selection($id);
			$data['bib']         = $this->Project_Model->get_name_bibs($id);
			$data['num_papers']  = $this->Project_Model->get_num_papers($id);

			// Study Selection tab
			$data['count_papers'] = $this->Project_Model->count_papers_sel_by_user($id);
			$data['criterias']    = $this->Project_Model->get_evaluation_selection($id);

			// Quality Assessment tab
			$data['project_quality']  = $this->Project_Model->get_project_quality($id);
			$data['count_papers_qa']  = $this->Project_Model->count_papers_qa_by_user($id);
			$data['qas_score']        = $this->Project_Model->get_evaluation_qa($id);

			// Data Extraction tab
			$data['count_papers_extraction'] = $this->Project_Model->count_papers_extraction($id);

			$this->load_views('pages/project/conducting/conducting', $data);
		} catch (Exception $e) {
			$this->session->set_flashdata('error', $e->getMessage());
			redirect(base_url());
		}
	}

	/**
	 * Reporting page
	 * URL: /project/reporting/{id}
	 */
	public function reporting($id)
	{
		try {
			$this->validate_level($id, [1, 2, 3, 4]);
			$this->load->model('Project_Model');

			$data['project']           = $this->Project_Model->get_project_report($id);
			$data['databases']         = $this->Project_Model->get_papers_database($id);
			$data['status_selection']  = $this->Project_Model->get_papers_status_selection($id);
			$data['status_qa']         = $this->Project_Model->get_papers_status_quality($id);
			$data['funnel']            = $this->Project_Model->get_papers_step($id);
			$data['activity']          = $this->Project_Model->get_act_project($id);
			$data['gen_score']         = $this->Project_Model->get_papers_score_quality($id);
			$data['extraction']        = $this->Project_Model->get_data_qes_select($id);
			$data['multiple']          = $this->Project_Model->get_data_qes_multiple($id);
			$data['count_project']     = $this->Project_Model->count_papers_by_status_qa($id);
			$data['papers']            = $this->Project_Model->get_papers_qa_visitor($id);
			$data['qas_score']         = $this->Project_Model->get_evaluation_qa_latex($id);
			$data['count_papers']      = $this->Project_Model->count_papers_reviewer_qa($id);
			$data['count_project_sel'] = $this->Project_Model->count_papers_by_status_sel($id);
			$data['count_papers_sel']  = $this->Project_Model->count_papers_reviewer($id);

			$this->load_views('pages/project/reporting/reporting', $data);
		} catch (Exception $e) {
			$this->session->set_flashdata('error', $e->getMessage());
			redirect(base_url());
		}
	}

	/**
	 * Review study selection page
	 * URL: /project/review_study_selection/{id}
	 */
	public function review_study_selection($id)
	{
		try {
			$this->validate_level($id, [1, 2, 3, 4]);
			$this->load->model('Project_Model');
			$this->load->model('Selection_Model');

			$data['project']       = $this->Project_Model->get_project_reviewer_selection($id);
			$data['count_project'] = $this->Project_Model->count_papers_by_status_sel($id);
			$data['count_papers']  = $this->Project_Model->count_papers_reviewer($id);
			$data['status']        = $this->Project_Model->get_status();
			$data['conflicts']     = $this->Selection_Model->get_conflicts($id);

			$this->load_views('pages/project/project_review_study_selection', $data);
		} catch (Exception $e) {
			$this->session->set_flashdata('error', $e->getMessage());
			redirect(base_url());
		}
	}

	/**
	 * Review quality assessment page
	 * URL: /project/review_qa/{id}
	 */
	public function review_qa($id)
	{
		try {
			$this->validate_level($id, [1, 2, 3, 4]);
			$this->load->model('Project_Model');
			$this->load->model('Quality_Model');

			$data['project']       = $this->Project_Model->get_project_quality($id);
			$data['count_project'] = $this->Project_Model->count_papers_by_status_qa($id);
			$data['count_papers']  = $this->Project_Model->count_papers_reviewer_qa($id);
			$data['status']        = $this->Project_Model->get_status_qa();
			$data['conflicts']     = $this->Quality_Model->get_conflicts($id);

			$this->load_views('pages/project/project_review_qa', $data);
		} catch (Exception $e) {
			$this->session->set_flashdata('error', $e->getMessage());
			redirect(base_url());
		}
	}

	/**
	 * Export page
	 * URL: /project/export/{id}
	 */
	public function export($id)
	{
		try {
			$this->validate_level($id, [1, 2, 3, 4]);
			$this->load->model('Project_Model');

			$data['project'] = $this->Project_Model->get_project_export($id);

			$this->load_views('pages/project/project_export', $data);
		} catch (Exception $e) {
			$this->session->set_flashdata('error', $e->getMessage());
			redirect(base_url());
		}
	}

	/**
	 * New project page
	 * URL: /project/new_project
	 */
	public function new_project()
	{
		try {
			$this->logged_in();
			$this->load->model('User_Model');

			$data['projects'] = $this->User_Model->get_projects_new($this->session->email);

			load_templates('pages/project/project_new', $data);
		} catch (Exception $e) {
			$this->session->set_flashdata('error', $e->getMessage());
			redirect(base_url());
		}
	}

	/**
	 * Edit project page
	 * URL: /project/edit/{id}
	 */
	public function edit($id)
	{
		try {
			$this->validate_level($id, [1]);
			$this->load->model('Project_Model');

			$data['project'] = $this->Project_Model->get_project_edit($id);

			$this->load_views('pages/project/edit', $data);
		} catch (Exception $e) {
			$this->session->set_flashdata('error', $e->getMessage());
			redirect(base_url());
		}
	}

	/**
	 * Add research members page
	 * URL: /project/add_research/{id}
	 */
	public function add_member($id)
	{
		try {
			$this->validate_level($id, [1]);
			$this->load->model('Project_Model');

			$data['project'] = $this->Project_Model->get_project_members($id);
			$data['users']   = $this->Project_Model->get_users($id);
			$data['levels']  = $this->Project_Model->get_levels();

			$this->load_views('pages/project/add_member', $data);
		} catch (Exception $e) {
			$this->session->set_flashdata('error', $e->getMessage());
			redirect(base_url());
		}
	}

    // -------------------------------------------------------------------------
    // POST actions
    // -------------------------------------------------------------------------

	/**
	 * Handle project creation form submission
	 * URL: /project/created_project
	 */
	public function created_project()
	{
		try {
			$this->logged_in();

			$title       = $this->input->post('title');
			$description = $this->input->post('description');
			$objectives  = $this->input->post('objectives');
			$protocol    = $this->input->post('protocol');

			$this->load->model('Project_Model');
			$id_project = $this->Project_Model->create_project(
				$title,
				$description,
				$objectives,
				$this->session->email
			);

			if ($protocol !== '') {
				$service = new ProjectProtocolService();
				$service->copy($protocol, $id_project);
			}

			$this->insert_log('Created the project ' . $title, 1, $id_project);

			redirect('open/' . $id_project);
		} catch (Exception $e) {
			$this->session->set_flashdata('error', $e->getMessage());
			redirect(base_url());
		}
	}

	/**
	 * Handle project edit form submission
	 * URL: /project/edited_project
	 */
	public function edited_project()
	{
		try {
			$id_project  = $this->input->post('id_project');
			$title       = $this->input->post('title');
			$description = $this->input->post('description');
			$objectives  = $this->input->post('objectives');

			$this->validate_level($id_project, [1]);
			$this->load->model('Project_Model');
			$this->Project_Model->edit_project($title, $description, $objectives, $id_project);

			$this->insert_log('Edited project', 1, $id_project);
		} catch (Exception $e) {
			$this->session->set_flashdata('error', $e->getMessage());
			redirect(base_url());
		}
	}

	/**
	 * Handle project deletion
	 * URL: /project/deleted_project
	 */
	public function deleted_project()
	{
		try {
			$id_project = $this->input->post('id_project');

			$this->validate_level($id_project, [1]);
			$this->load->model('Project_Model');
			$this->Project_Model->delete_project($id_project);

			$this->insert_log('Deleted project ' . $id_project, 1, null);
		} catch (Exception $e) {
			$this->session->set_flashdata('error', $e->getMessage());
			redirect(base_url());
		}
	}
}
