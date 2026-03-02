<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'controllers/Pattern_Controller.php';

class About_Controller extends Pattern_Controller
{
	private const GITHUB_CONTRIBUTORS_API = 'https://api.github.com/repos/auri-gabriel/thoth/contributors?per_page=100';

	/**
	 *
	 */
	public function index()
	{
		$contributors = $this->get_github_contributors();

		$this->render(
			'pages/about',
			[
				'contributors' => $contributors,
			]
		);
	}

	private function get_github_contributors()
	{
		$response = $this->request_github_contributors();

		if ($response === null) {
			return [];
		}

		$data = json_decode($response, true);

		if (!is_array($data)) {
			return [];
		}

		$contributors = [];

		foreach ($data as $contributor) {
			if (!is_array($contributor)) {
				continue;
			}

			$login = $contributor['login'] ?? null;
			$profile_url = $contributor['html_url'] ?? null;
			$avatar_url = $contributor['avatar_url'] ?? null;
			$contributions = $contributor['contributions'] ?? 0;

			if (!$login || !$profile_url || !$avatar_url) {
				continue;
			}

			$contributors[] = [
				'login' => $login,
				'profile_url' => $profile_url,
				'avatar_url' => $avatar_url,
				'contributions' => (int) $contributions,
			];
		}

		return $contributors;
	}

	private function request_github_contributors()
	{
		if (function_exists('curl_init')) {
			$curl = curl_init();

			curl_setopt_array($curl, [
				CURLOPT_URL => self::GITHUB_CONTRIBUTORS_API,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_TIMEOUT => 5,
				CURLOPT_HTTPHEADER => [
					'Accept: application/vnd.github+json',
					'User-Agent: Thoth-About-Page',
				],
			]);

			$response = curl_exec($curl);
			$http_code = (int) curl_getinfo($curl, CURLINFO_HTTP_CODE);
			curl_close($curl);

			if ($response !== false && $http_code >= 200 && $http_code < 300) {
				return $response;
			}
		}

		$context = stream_context_create([
			'http' => [
				'method' => 'GET',
				'timeout' => 5,
				'header' => "Accept: application/vnd.github+json\r\nUser-Agent: Thoth-About-Page\r\n",
			],
		]);

		$response = @file_get_contents(self::GITHUB_CONTRIBUTORS_API, false, $context);

		if ($response === false) {
			return null;
		}

		return $response;
	}
}
