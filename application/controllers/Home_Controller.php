<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'controllers/Pattern_Controller.php';

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

		load_templates('home', null);
	}
}
