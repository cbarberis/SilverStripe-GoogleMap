<?php

Director::addRules(50, array(
	'googleapi/$Action/$ID/$OtherID/$ExtraID' => 'GoogleAPI_Controller'
));

GoogleAPI_Controller::set_google_api_url('https://maps.googleapis.com/maps/api/place/');
Object::add_Extension('GoogleMapPage','GoogleMapsDecorator');

/**
 * Do not forget to define GOOGLE API KEY in mysite/_config.php
 * GoogleAPI_Controller::set_google_api_key('<your google api key here>');
 *
 * You can add a country filter to make the address suggestions call faster, i.e. this line will return addresses just from New Zealand.
 * GoogleAPI_Controller::set_filter_by_country('nz');
**/

