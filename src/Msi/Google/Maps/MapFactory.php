<?php

namespace Google\Maps;

class MapFactory
{
    public function create(array $options = array())
    {
        return new Map($options);
    }
}
