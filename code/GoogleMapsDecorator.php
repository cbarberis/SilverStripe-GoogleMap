<?php 

class GoogleMapsDecorator extends DataObjectDecorator {

	function extraStatics() {
		return array(
			'db' => array(
				'LonCenter' => 'Varchar(16)',
				'LatCenter' => 'Varchar(16)',
				'Zoom' => 'Varchar(2)'
			),
			'has_many' => array(
				'GoogleMapsPoits' => 'GoogleMapsPoint'
			)
		);
	}

	function updateCMSFields(&$fields) {
		Requirements::javascript('googlemaps/javascript/jquery.entwine-dist.js');
		Requirements::javascript('googlemaps/javascript/googleMapsPointField.js');
		
		$addresses = new HasManyComplexTableField(
	    	$this->owner,
	        'GoogleMapsPoits',
	        'GoogleMapsPoint',
	        array(
		    	'Address' => 'Address',
				'Popup' => 'Popup content'
	         ),
	        'getCMSFields_forPopup'
	      );
	    
		$fields->addFieldToTab('Root.Content.GoogleMap', $addresses );
		$fields->addFieldToTab('Root.Content.GoogleMap', new TextField('LonCenter', 'Map Center (longitud)'));
		$fields->addFieldToTab('Root.Content.GoogleMap', new TextField('LatCenter', 'Map Center (latitude)'));
		$fields->addFieldToTab('Root.Content.GoogleMap', new TextField('Zoom', 'Map Default Zoom'));
	}

	/**
	 * this function renders a json string with the points for the map plus center point and zoom.
	 * it also renders the div for the map, so the only thing you need to add toy the template is $RenderMap
	 * to change the map dimension use css #map_canvas
	**/
	function RenderMap() {
		Requirements::javascript(SAPPHIRE_DIR . '/thirdparty/jquery/jquery.js');
		Requirements::javascript('https://maps.googleapis.com/maps/api/js?sensor=false');
		Requirements::javascript('googlemaps/javascript/googleMapsFrontEnd.js');
		Requirements::css('googlemaps/css/googleMapsFrontEnd.css');
		$points = $this->owner->getComponents('GoogleMapsPoits');
		$jsonPoints = 'var points = [';
		if($points)  {
			foreach($points as $point) 
				$jsonPoints .= '{ID:'.$point->ID.',Lon:'.$point->Lon.',Lat:'.$point->Lat.',Address:"'.$point->Address.'",Popup:"'.$point->Popup.'"},';
			$jsonPoints = substr($jsonPoints, 0, strlen($jsonPoints)-1);
			$zoom = ($this->owner->Zoom) ? $this->owner->Zoom : '8';
			$jsonPoints .= ']; var zoom = ' . $zoom . '; var center = [{Lon:' . $this->owner->LonCenter . ',Lat:' . $this->owner->LatCenter . '}]';
		} else {
			$jsonPoints .= '];';
		}
		
		Requirements::customScript($jsonPoints);
		return '<div id="map_canvas"></div>';
	}

}

