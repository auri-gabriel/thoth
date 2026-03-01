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
				'pages/dashboard',
				['data' => $data]
			);
		} catch (Exception $e) {
			$this->session->set_flashdata('error', $e->getMessage());
			$this->render(
				'pages/dashboard',
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
		$this->load->model('User_Model');
		$this->load->library('form_validation');

		$email = $this->session->userdata('email');
		$user = $this->User_Model->get_user_by_email($email);

		if ($this->input->method() === 'post') {
			$this->form_validation->set_rules('name', 'Name', 'required');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
			$this->form_validation->set_rules('new_password', 'New Password', 'min_length[6]');
			$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'matches[new_password]');

			if ($this->form_validation->run() === TRUE) {
				$update_data = [
					'name' => $this->input->post('name'),
					'email' => $this->input->post('email'),
					'institution' => $this->input->post('institution'),
					'lattes_link' => $this->input->post('lattes_link')
				];
				if ($this->input->post('new_password')) {
					$update_data['password'] = password_hash($this->input->post('new_password'), PASSWORD_DEFAULT);
				}

				$success = $this->User_Model->update_user($email, $update_data);
				if ($success) {
					$this->session->set_flashdata('success', 'Profile updated successfully.');
					if ($email !== $update_data['email']) {
						$this->session->set_userdata('email', $update_data['email']);
					}
					redirect(current_url());
				} else {
					$this->session->set_flashdata('error', 'Failed to update profile.');
					redirect(current_url());
				}
			} else {
				$this->session->set_flashdata('error', validation_errors());
				redirect(current_url());
			}
		}

		// Refresh user data after update or for GET
		$email = $this->session->userdata('email');
		$user = $this->User_Model->get_user_by_email($email);

		$this->render('pages/user/profile', ['user' => $user]);
	}
}
