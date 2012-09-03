PHP Google
==========

PHP wrappers for some Google APIs and tools.

Google Maps API
------------------

``` php
use Msi\Google\Maps\Map;

$map = new Map();

$map->addOverlay('marker', array(
    'position' => $map->latlng(45.5086699, -73.5539925),
    'title' => '"some_title"',
    'icon' => '"path_to_some_icon_image"',
));
```

``` php
<div id="mapCanvas" style="width:100%; height:100%"></div>

<?php echo $map->toJs() ?>
```

Google Chart Tools
------------------

maybe coming soon