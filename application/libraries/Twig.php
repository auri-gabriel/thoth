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
		// Add CodeIgniter form helper functions to Twig
		$this->CI->load->helper('form');
		$this->twig->addFunction(new TwigFunction('form_open', function ($action = '', $attributes = []) {
			return form_open($action, $attributes);
		}, ['is_safe' => ['html']]));
		$this->twig->addFunction(new TwigFunction('form_close', function () {
			return form_close();
		}, ['is_safe' => ['html']]));
		$this->twig->addFunction(new TwigFunction('form_input', function ($data = '', $value = '', $extra = '') {
			return form_input($data, $value, $extra);
		}, ['is_safe' => ['html']]));
		$this->twig->addFunction(new TwigFunction('form_password', function ($data = '', $value = '', $extra = '') {
			return form_password($data, $value, $extra);
		}, ['is_safe' => ['html']]));
		$this->twig->addFunction(new TwigFunction('form_submit', function ($data = '', $value = '', $extra = '') {
			return form_submit($data, $value, $extra);
		}, ['is_safe' => ['html']]));
		$this->twig->addFunction(new TwigFunction('form_label', function ($label_text = '', $id = '', $attributes = []) {
			return form_label($label_text, $id, $attributes);
		}, ['is_safe' => ['html']]));
		$this->twig->addFunction(new TwigFunction('form_error', function ($field = '', $prefix = '', $suffix = '') {
			return form_error($field, $prefix, $suffix);
		}, ['is_safe' => ['html']]));
		$this->twig->addFunction(new TwigFunction('set_value', function ($field = '', $default = '') {
			return set_value($field, $default);
		}));
	}

	public function render($template, $data = [])
	{
		return $this->twig->render($template, $data);
	}
}
