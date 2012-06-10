<?php

class GoogleAPI_Controller extends Controller {


	protected static $google_api_key;

	protected static $google_api_url;

	protected static $filter_by_country;

	static function set_google_api_key($key) {
		self::$google_api_key = $key;
	}

	static function get_google_api_key() {
		return self::$google_api_key;
	}

	static function set_google_api_url($url) {
		self::$google_api_url = $url;
	}

	static function get_google_api_url() {
		return self::$google_api_url;
	}

	static function set_filter_by_country($filter) {
		self::$filter_by_country = $filter;
	}

	static function get_filter_by_country() {
		return self::$filter_by_country;
	}

	function init(){
		parent::init();
	}

	function getSuggestions($request) {
		$postsVars = $request->postVars(); 
		$resp = $this->callAPI($postsVars['address'], 'autocomplete');

		if(isset($resp->predictions) && is_array($resp->predictions) && !empty($resp->predictions)) {
			$html = "<ul>";
			foreach($resp->predictions as $desc) {
				$html .= "<li><a href='#' id='" . $desc->reference . "'>" . $desc->description . "</a></li>";
			}
			$html .= "</ul>";
		} else {
			$html = "<ul><li>NO RESULTS FOUND</li></ul>";
		}
		
		return $html;
	}

	function getCoordinates($request) {

		$postsVars = $request->postVars(); 
		$resp = $this->callAPI($postsVars['reference'], 'details');
		if($resp->result->geometry->location) return json_encode($resp->result->geometry->location);
		return 'bad';
	}

	function callAPI($details = null, $call = null){
		
		$req = new RestfulService(self::get_google_api_url() . $call . '/json');
		$queryString = ($call == 'autocomplete') ? $this->getAutocumpleteQueryString($details) : $this->getDetailsQueryString($details);
		$req->setQueryString($queryString);		
		$response = $req->request();
		return json_decode($response->getBody());
		
	}

	protected function getAutocumpleteQueryString($details) {
		// https://maps.googleapis.com/maps/api/place/autocomplete/json?input=99%20courtenay%20place&sensor=true&types=geocode&components=country:nz&key=<apikey>
		$components = array(
			'input' => urlencode(trim($details)),
			'sensor' => 'true',
			'types' => 'geocode',
			'key' => self::get_google_api_key()
		);

		if(self::$filter_by_country) return array_merge(array('components' => 'country:'.self::get_filter_by_country()), $components);
		return $components;
	}

	protected function getDetailsQueryString($reference) {
		// https://maps.googleapis.com/maps/api/place/details/json?reference=CjQvAAAAQMCZbSAJ0UNuwhVMOW9zT9_xAppY7mu1WfhKLuXhSHa3NOAw7khXjEsZlrJwckk3EhB4xEIi-X-wkzFyuR6XxzkjGhTmSZ1kCOxUDXjrGIYhQoOGBMGbgA&sensor=true&key=<apikey>
		return array(
			'reference' => $reference,
			'key' => self::get_google_api_key(),
			'sensor' => 'true'
		);
	}
}