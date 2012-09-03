<?php

namespace Google\Maps;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class Map
{
    protected $key;

    protected $mapDivId;

    protected $options;

    protected $attributes = array();

    protected $id;

    protected $overlays = array();

    public function __construct($mapDivId, array $options = array())
    {
        $this->id = 'map'.uniqid();
        $this->mapDivId = $mapDivId;

        $resolver = new OptionsResolver();
        $this->setDefaultOptions($resolver);
        $this->options = $resolver->resolve($options);
    }

    public function geocode($address)
    {
        $json = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?sensor=false&address='.urlencode($address));
        $json = json_decode(utf8_encode($json), true);

        if ($json['status'] === 'OK') {
            return $json;
        }

        die($json['status'].' https://developers.google.com/maps/documentation/geocoding/#StatusCodes');
    }

    public function latlng($lat, $lng)
    {
        return 'new google.maps.LatLng('.$lat.', '.$lng.')';
    }

    public function calculateDistance($lat1, $lng1, $lat2, $lng2) {
        $theta = $lng1 - $lng2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;

        // Kilometers
        return ($miles * 1.609344);
    }

    public function __toString()
    {
        return $this->id;
    }

    public function getAttribute($key, $default = null)
    {
        if (isset($this->attributes[$key])) {
            return $this->attributes[$key];
        }

        return $default;
    }

    public function setAttribute($key, $value)
    {
        $this->attributes[$key] = $value;

        return $this;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    public function addOverlay($class, array $options = array())
    {
        $this->overlays[] = array('class' => $class, 'options' => array_merge(array('map' => $this), $options));

        return $this;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    public function getMapDivId()
    {
        return $this->mapDivId;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function getOverlays()
    {
        return $this->overlays;
    }

    public function toJs()
    {
        $renderer = new MapRenderer();

        return $renderer->render($this);
    }

    protected function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'center' => 'new google.maps.LatLng(-34.397, 150.644)',
            'zoom' => 4,
            'mapTypeId' => 'google.maps.MapTypeId.ROADMAP',
        ));
    }
}
