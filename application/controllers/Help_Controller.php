<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'controllers/Pattern_Controller.php';

class Help_Controller extends Pattern_Controller
{
	/**
	 *
	 */
	public function index()
	{
		$this->render(
			'pages/help.twig'
		);
	}
}
