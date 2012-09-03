<?php

namespace Google\Maps;

class MapFactory
{
    public function create($mapDiv, array $options = array())
    {
        return new Map($mapDiv, $options);
    }
}
