<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'controllers/Pattern_Controller.php';

class About_Controller extends Pattern_Controller
{
	/**
	 *
	 */
	public function index()
	{
		$this->render(
			'pages/about'
		);
	}
}
