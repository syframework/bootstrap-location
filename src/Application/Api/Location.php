<?php
namespace Sy\Bootstrap\Application\Api;

use Sy\Bootstrap\Component\Api;
use Sy\Bootstrap\Service\Container;

class Location extends Api {

	public function security() {
		$origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : null;
		if (empty($origin) and isset($_SERVER['HTTP_REFERER'])) {
			$origin = $_SERVER['HTTP_REFERER'];
		}
		if (empty($origin)) {
			$this->forbidden();
		}
		if ($_SERVER['SERVER_NAME'] !== parse_url($origin)['host']) {
			$this->forbidden();
		}
	}

	/**
	 * Retrieve the country iso code using the client ip address
	 */
	public function getAction() {
		$service = Container::getInstance();
		echo $service->location->getCountryIsoCode();
		exit;
	}

}