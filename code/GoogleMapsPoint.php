<?php

class GoogleMapsPoint extends DataObject {
	/**
	 * simple DO to store points in the DB. It has a has_one to a Page which contains the map.
	 * Popup is the popup or bubble for the point.
	**/
	static $db = array(
		'Address' => 'Varchar(255)',
		'Popup' => 'Varchar(255)',
		'Lon' => 'Varchar(18)',
		'Lat' => 'Varchar(18)'
	);

	static $has_one = array(
		'GoogleMaps' => 'Page'
	);

	function getCMSFields_forPopup() {
		
		Requirements::javascript('googlemaps/javascript/googleMapsPointField.js');
	    $fields = new FieldSet();
	    $fields->push( new TextField('Address', 'Address'));
	    $fields->push( new Literalfield('AddressSuggestions', '<div id="suggestionsAddress"></div>'));
		$fields->push( new TextField('Popup', 'Popup content'));
		$fields->push( new HiddenField('Lon', 'Lon', ''));
		$fields->push( new HiddenField('Lat', 'Lat', ''));
	   	return $fields;
	}

	public function getRequirementsForPopup() {
		
		Requirements::javascript(THIRDPARTY_DIR . '/jquery/jquery.js');
		Requirements::javascript('googlemaps/javascript/jquery.entwine-dist.js');
		Requirements::javascript('googlemaps/javascript/googleMapsPointField.js');
		Requirements::javascript('googlemaps/javascript/googlePlaces.js');
	}

	function onBeforeWrite() {
		
		$this->GoogleMapsID = $this->record['ctf[sourceID]'];
 		parent::onBeforeWrite();

	}

}