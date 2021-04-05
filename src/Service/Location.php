<?php
namespace Sy\Bootstrap\Service;

class Location {

	private $ip;

	private $country;

	private $city;

	public function __construct() {
		$ip = 0;
		if (isset($_SERVER['REMOTE_ADDR'])) $ip = $_SERVER['REMOTE_ADDR'];
		if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) $ip = $_SERVER['HTTP_CF_CONNECTING_IP']; // Cloudflare
		$this->ip = $ip;
	}

	public function getCountry() {
		if (!isset($this->country)) {
			$reader = new \GeoIp2\Database\Reader(__DIR__ . '/../../geolite2/GeoLite2-Country.mmdb');
			$this->country = $reader->country($this->ip);
		}
		return $this->country;
	}

	public function getCity() {
		if (!isset($this->city)) {
			$reader = new \GeoIp2\Database\Reader(__DIR__ . '/../../geolite2/GeoLite2-City.mmdb');
			$this->city = $reader->city($this->ip);
		}
		return $this->city;
	}

	/**
	 * Return the lat/lng coordinates using client ip address
	 * 
	 * @param array $default Default lat/lng coordinates if location can't be found
	 * @return array
	 */
	public function getLatLng(array $default = ['lat' => 48.856869, 'lng' => 2.351477]) {
		try {
			return [
				'lat' => $this->getCity()->location->latitude,
				'lng' => $this->getCity()->location->longitude,
			];
		} catch (\Exception $e) {
			return $default;
		}
	}

	/**
	 * Return the country iso code using client ip address
	 *
	 * @return string
	 */
	public function getCountryIsoCode() {
		try {
			return $this->getCountry()->country->isoCode;
		} catch (\Exception $e) {
			return '';
		}
	}

}