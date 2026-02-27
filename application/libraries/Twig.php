<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;

class Twig
{

	protected $CI;
	protected $twig;

	public function __construct()
	{
		$this->CI = &get_instance();

		$loader = new FilesystemLoader(APPPATH . 'views');

		$this->twig = new Environment($loader, [
			'cache' => FALSE,
			'debug' => TRUE
		]);

		$this->twig->addExtension(new \Twig\Extension\DebugExtension());

		$this->twig->addFunction(
			new TwigFunction('base_url', function ($uri = '') {
				return base_url($uri);
			})
		);
		$this->twig->addFunction(
			new TwigFunction('site_url', function ($uri = '') {
				return site_url($uri);
			})
		);
	}

	public function render($template, $data = [])
	{
		return $this->twig->render($template, $data);
	}
}
