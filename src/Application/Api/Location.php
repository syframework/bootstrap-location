<?php
namespace Sy\Bootstrap\Application\Api;

use Sy\Bootstrap\Component\Api;

class Location extends Api {

	public function security() {
		$origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : null;
		if (empty($origin) and isset($_SERVER['HTTP_REFERER'])) {
			$origin = $_SERVER['HTTP_REFERER'];
		}
		if (empty($origin)) {
			throw new Api\ForbiddenException('No origin found');
		}
		if ($_SERVER['SERVER_NAME'] !== parse_url($origin)['host']) {
			throw new Api\ForbiddenException('Origin denied');
		}
	}

	/**
	 * Retrieve the country iso code using the client ip address
	 */
	public function getAction() {
		$service = \Project\Service\Container::getInstance();
		$code = $service->location->getCountryIsoCode();
		if (empty($code)) return $this->ok($this->get('default', 'us'));
		return $this->ok($code);
	}

}