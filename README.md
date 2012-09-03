PHP Google APIs
===============

PHP wrappers for some of Google's APIs.

Usage
-----

``` php
use Google\Maps\Map;

$map = new Map();

$map->addOverlay('marker', array(
    'position' => $map->latlng(45.5086699, -73.5539925),
    'title' => '"some_title"',
    'icon' => '"path_to_some_icon_image"',
));
```

``` html
{{ msi_google_render_map_html(map) }}

<!-- ... -->

{{ msi_google_render_map_js(map) }}
```