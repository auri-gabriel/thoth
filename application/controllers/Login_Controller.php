<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'controllers/Pattern_Controller.php';

/**
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property CI_Session $session
 * @property User_Model $User_Model
 * @property Login_Model $Login_Model
 */
class Login_Controller extends Pattern_Controller

{
	/**
	 *
	 */
	public function index() {}

	/**
	 *
	 */
	public function log_into()
	{
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', trim(validation_errors()));
			redirect(base_url("login"));
		}
		try {
			$this->load->model("Login_Model");
			$email = $this->input->post('email');
			$password = $this->input->post('password');
			$user = $this->Login_Model->check_login($email, $password);

			if (is_null($user)) {
				$this->session->set_flashdata('error', 'Email or Password invalid!');
				redirect(base_url("login"));
			}

			$session = array(
				'name' => $user->get_name(),
				'email' => $user->get_email(),
				'logged_in' => true,
				'level' => null
			);

			$this->session->set_userdata($session);

			$activity = "Logged in";
			$this->insert_log($activity, 2, null);

			redirect(base_url("dashboard"));
		} catch (Exception $e) {
			$this->session->set_flashdata('error', $e->getMessage());
			redirect(base_url("login"));
		}
	}

	/**
	 *
	 */
	public function log_up()
	{
		try {
			$this->load->model("Login_Model");
			$email = $this->input->post('email');


			if (!$this->Login_Model->check_email_unique($email)) {
				$this->session->set_flashdata('error', 'Email already used!');
				redirect(base_url("register"));
			}

			$password = md5($this->input->post('password'));
			$name = $this->input->post('name');

			$user = $this->Login_Model->new_user($email, $password, $name);

			$session = array(
				'name' => $user->get_name(),
				'email' => $user->get_email(),
				'logged_in' => true,
				'level' => null
			);

			$this->session->set_userdata($session);

			$activity = "Created new user and logged in";
			$this->insert_log($activity, 2, null);

			redirect(base_url("dashboard"));
		} catch (Exception $e) {
			$this->session->set_flashdata('error', $e->getMessage());
			redirect(base_url("register"));
		}
	}

	/**
	 *
	 */
	public function login()
	{
		try {
			if ($this->session->logged_in) {
				redirect(base_url("dashboard"));
			}
			$this->render(
				'pages/login/login'
			);
		} catch (Exception $e) {
			$this->session->set_flashdata('error', $e->getMessage());
			redirect(base_url());
		}
	}

	/**
	 *
	 */
	public function logout()
	{
		try {
			$activity = "Logged out";
			$this->insert_log($activity, 2, null);

			$this->session->sess_destroy();
			redirect(base_url());
		} catch (Exception $e) {
			$this->session->set_flashdata('error', $e->getMessage());
			redirect(base_url());
		}
	}

	/**
	 *
	 */
	public function register()
	{
		try {
			if ($this->session->logged_in) {
				redirect(base_url("dashboard"));
			}
			$this->render(
				'pages/login/register'
			);
		} catch (Exception $e) {
			$this->session->set_flashdata('error', $e->getMessage());
			redirect(base_url());
		}
	}

	/**
	 * Show forgot password form
	 */
	public function forgot_password()
	{
		try {
			$this->render('pages/login/forgot_password');
		} catch (Exception $e) {
			$this->session->set_flashdata('error', $e->getMessage());
			redirect(base_url('login'));
		}
	}

	/**
	 * Handle reset link request and send email
	 */
	public function send_reset_link()
	{
		$this->load->model('Login_Model');
		$email = $this->input->post('email');
		$user = $this->Login_Model->find_by_email($email);
		if (!$user) {
			$this->session->set_flashdata('error', 'Email not found.');
			redirect(base_url('login/forgot_password'));
		}
		$token = bin2hex(random_bytes(32));
		$this->Login_Model->store_reset_token($user->get_id(), $token);
		$reset_link = base_url('login/reset_password/' . $token);
		$this->load->library('email');
		$this->email->from('no-reply@yourdomain.com', 'Thoth');
		$this->email->to($email);
		$this->email->subject('Password Reset Request');
		$this->email->message("Click the following link to reset your password: $reset_link");
		if ($this->email->send()) {
			$this->session->set_flashdata('success', 'Reset link sent to your email.');
		} else {
			$this->session->set_flashdata('error', 'Failed to send email.');
		}
		redirect(base_url('login/forgot_password'));
	}

	/**
	 * Show reset password form
	 */
	public function reset_password($token = null)
	{
		$this->load->model('Login_Model');
		if (!$token || !$this->Login_Model->is_valid_token($token)) {
			$this->session->set_flashdata('error', 'Invalid or expired token.');
			redirect(base_url('login/forgot_password'));
		}
		$data = ['token' => $token];
		$this->render('pages/login/reset_password', $data);
	}

	/**
	 * Update password after reset
	 */
	public function update_password()
	{
		$this->load->model('Login_Model');
		$token = $this->input->post('token');
		$new_password = $this->input->post('new_password');
		$confirm_password = $this->input->post('confirm_password');
		if ($new_password !== $confirm_password) {
			$this->session->set_flashdata('error', 'Passwords do not match.');
			redirect(base_url('login/reset_password/' . $token));
		}
		if (!$this->Login_Model->is_valid_token($token)) {
			$this->session->set_flashdata('error', 'Invalid or expired token.');
			redirect(base_url('login/forgot_password'));
		}
		$user_id = $this->Login_Model->get_user_id_by_token($token);
		$this->Login_Model->update_password($user_id, $new_password);
		$this->Login_Model->invalidate_token($token);
		$this->session->set_flashdata('success', 'Password updated successfully. You can now log in.');
		redirect(base_url('login'));
	}
}
