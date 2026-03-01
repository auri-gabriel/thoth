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

		$email = $this->session->userdata('email');
		$user = $this->User_Model->get_user_by_email($email);

		$this->render('pages/user/profile', ['user' => $user]);
	}

	// Update basic info (name, email)
	public function update_basic_info()
	{
		$this->logged_in();
		$this->load->model('User_Model');
		$this->load->library('form_validation');

		$email = $this->session->userdata('email');

		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');

		if ($this->form_validation->run() === TRUE) {
			$new_email = $this->input->post('email');
			// Check if email is unique if changed
			if ($email !== $new_email && !$this->User_Model->is_email_unique($new_email)) {
				$this->session->set_flashdata('basic_info_error', 'Email is already in use.');
				redirect('user/profile');
			}
			$update_data = [
				'name' => $this->input->post('name'),
				'email' => $new_email
			];
			$success = $this->User_Model->update_user($email, $update_data);
			if ($success) {
				$this->session->set_flashdata('basic_info_success', 'Basic info updated successfully.');
				$this->session->set_userdata('name', $update_data['name']);
				if ($email !== $new_email) {
					$this->session->set_userdata('email', $new_email);
				}
			} else {
				$this->session->set_flashdata('basic_info_error', 'Failed to update basic info.');
			}
		} else {
			$this->session->set_flashdata('basic_info_error', validation_errors());
		}
		redirect('profile');
	}

	// Update password
	public function update_password()
	{
		$this->logged_in();
		$this->load->model('User_Model');
		$this->load->library('form_validation');

		$email = $this->session->userdata('email');
		$user = $this->User_Model->get_user_by_email($email);

		$this->form_validation->set_rules('current_password', 'Current Password', 'required');
		$this->form_validation->set_rules('new_password', 'New Password', 'required|min_length[6]');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[new_password]');

		if ($this->form_validation->run() === TRUE) {
			// Verify current password
			if (!password_verify($this->input->post('current_password'), $user['password'])) {
				$this->session->set_flashdata('password_error', 'Current password is incorrect.');
				redirect('user/profile');
			}
			$update_data = [
				'password' => password_hash($this->input->post('new_password'), PASSWORD_DEFAULT)
			];
			$success = $this->User_Model->update_user($email, $update_data);
			if ($success) {
				$this->session->set_flashdata('password_success', 'Password updated successfully.');
			} else {
				$this->session->set_flashdata('password_error', 'Failed to update password.');
			}
		} else {
			$this->session->set_flashdata('password_error', validation_errors());
		}
		redirect('profile');
	}

	// Update institution and lattes link
	public function update_institution_lattes()
	{
		$this->logged_in();
		$this->load->model('User_Model');
		$this->load->library('form_validation');

		$email = $this->session->userdata('email');

		$this->form_validation->set_rules('institution', 'Institution', 'required');
		$this->form_validation->set_rules('lattes_link', 'Lattes Link', 'required|valid_url');

		if ($this->form_validation->run() === TRUE) {
			$update_data = [
				'institution' => $this->input->post('institution'),
				'lattes_link' => $this->input->post('lattes_link')
			];
			$success = $this->User_Model->update_user($email, $update_data);
			if ($success) {
				$this->session->set_flashdata('institution_success', 'Institution and Lattes updated successfully.');
			} else {
				$this->session->set_flashdata('institution_error', 'Failed to update institution and Lattes.');
			}
		} else {
			$this->session->set_flashdata('institution_error', validation_errors());
		}
		redirect('profile');
	}
}
