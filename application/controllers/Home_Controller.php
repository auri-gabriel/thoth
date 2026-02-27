<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'controllers/Pattern_Controller.php';

/**
 * @property Project_Model $Project_Model
 * @property User_Model $User_Model
 * @property Load $load
 * @property Session $session
 */
class Home_Controller extends Pattern_Controller
{
	/**
	 *
	 */
	public function index()
	{
		if ($this->session->logged_in) {
			redirect(base_url('dashboard'));
			return;
		}

		// Load models
		$this->load->model('Project_Model');
		$this->load->model('User_Model');

		// Fetch counts
		$project_count = $this->Project_Model->get_total_projects();
		$user_count = $this->User_Model->get_total_users();

		// Pass counts to view
		$data = [
			'project_count' => $project_count,
			'user_count' => $user_count
		];
		load_templates('home', $data);
	}
}
