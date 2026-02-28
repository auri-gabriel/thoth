<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'controllers/Pattern_Controller.php';

/**
 * @property User_Model $User_Model
 * @property Session $session
 * @property Load $load
 */
class User_Controller extends Pattern_Controller
{
	/**
	 *
	 */
	public function index()
	{
		$data = null;
		try {
			$this->logged_in();

			$this->load->model("User_Model");
			$data['projects'] = $this->User_Model->get_projects($this->session->email);

			$data['recent_activity'] = $this->User_Model->get_recent_activities($this->session->email);
			$this->render(
				'pages/dashboard.twig',
				['data' => $data]
			);
		} catch (Exception $e) {
			$this->session->set_flashdata('error', $e->getMessage());
			$this->render(
				'pages/dashboard.twig',
				['data' => $data]
			);
		}
	}

	/**
	 *
	 */
	public function profile()
	{
		$this->logged_in();
		$this->render(
			'pages/user/profile.twig'
		);
	}
}
