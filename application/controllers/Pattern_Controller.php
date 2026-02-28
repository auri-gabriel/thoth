<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Pattern_Controller extends CI_Controller
{
	/**
	 * Pattern_Controller constructor.
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 *
	 */
	public function index() {}

	/**
	 * @param $activity
	 * @param $module
	 * @param $id_project
	 */
	public function insert_log($activity, $module, $id_project)
	{
		$this->load->model("User_Model");
		$this->User_Model->insert_log($activity, $module, $id_project);
	}

	/**
	 *
	 */
	public function logged_in()
	{
		if (!$this->session->logged_in) {
			redirect(base_url());
		}
	}

	/**
	 * @param $id_project
	 * @param $levels
	 */
	public function validate_level($id_project, $levels)
	{
		$this->logged_in();
		$this->load->model("Project_Model");
		$this->session->set_userdata('level', $this->Project_Model->get_level($this->session->email, $id_project));
		$res_level = $this->session->level;

		foreach ($levels as $l) {
			if ($l == $res_level) {
				return $res_level;
			}
		}


		redirect(base_url());
	}

	protected function render($view, $data = [])
	{
		// Must be logged in
		if (!$this->session->logged_in) {
			redirect(base_url());
		}

		$level = $this->session->level;

		if (is_null($level)) {
			redirect(base_url());
		}

		switch ($level) {
			case 1: // Admin
			case 3: // Researcher
			case 4: // Reviser
				$final_view = $view;
				break;

			case 2: // Visitor
				$final_view = preg_replace(
					'/pages\/project\//',
					'pages/project/visitor/',
					$view
				);
				break;

			default:
				redirect(base_url());
		}

		// Inject global template data
		$data['session'] = $this->session;

		echo $this->twig->render($final_view . '.twig', $data);
	}
}
