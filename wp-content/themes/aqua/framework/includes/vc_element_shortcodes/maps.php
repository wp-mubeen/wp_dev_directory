<?php
vc_map(array(
    "name" => 'Google Maps',
    "base" => "maps",
    "category" => __('Aqua', 'aqua'),
	"icon" => "tb-icon-for-vc",
    "description" => __('Google Maps API V3', 'aqua'),
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => __('API Key', 'aqua'),
            "param_name" => "api",
            "value" => '',
            "description" => __('Enter you api key of map, get key from (https://console.developers.google.com)', 'aqua')
        ),
        array(
            "type" => "textfield",
            "heading" => __('Address', 'aqua'),
            "param_name" => "address",
            "value" => 'New York, United States',
            "description" => __('Enter address of Map', 'aqua')
        ),
        array(
            "type" => "textfield",
            "heading" => __('Coordinate', 'aqua'),
            "param_name" => "coordinate",
            "value" => '',
            "description" => __('Enter coordinate of Map, format input (latitude, longitude)', 'aqua')
        ),
        array(
            "type" => "checkbox",
            "heading" => __('Click Show Info window', 'aqua'),
            "param_name" => "infoclick",
            "value" => array(
                __("Yes, please", 'aqua') => true
            ),
            "group" => __("Marker", 'aqua'),
            "description" => __('Click a marker and show info window (Default Show).', 'aqua')
        ),
        array(
            "type" => "textfield",
            "heading" => __('Marker Coordinate', 'aqua'),
            "param_name" => "markercoordinate",
            "value" => '',
            "group" => __("Marker", 'aqua'),
            "description" => __('Enter marker coordinate of Map, format input (latitude, longitude)', 'aqua')
        ),
        array(
            "type" => "textfield",
            "heading" => __('Marker Title', 'aqua'),
            "param_name" => "markertitle",
            "value" => '',
            "group" => __("Marker", 'aqua'),
            "description" => __('Enter Title Info windows for marker', 'aqua')
        ),
        array(
            "type" => "textarea",
            "heading" => __('Marker Description', 'aqua'),
            "param_name" => "markerdesc",
            "value" => '',
            "group" => __("Marker", 'aqua'),
            "description" => __('Enter Description Info windows for marker', 'aqua')
        ),
        array(
            "type" => "attach_image",
            "heading" => __('Marker Icon', 'aqua'),
            "param_name" => "markericon",
            "value" => '',
            "group" => __("Marker", 'aqua'),
            "description" => __('Select image icon for marker', 'aqua')
        ),
        array(
            "type" => "textarea_raw_html",
            "heading" => __('Marker List', 'aqua'),
            "param_name" => "markerlist",
            "value" => '',
            "group" => __("Multiple Marker", 'aqua'),
            "description" => __('[{"coordinate":"41.058846,-73.539423","icon":"","title":"title demo 1","desc":"desc demo 1"},{"coordinate":"40.975699,-73.717636","icon":"","title":"title demo 2","desc":"desc demo 2"},{"coordinate":"41.082606,-73.469718","icon":"","title":"title demo 3","desc":"desc demo 3"}]', 'aqua')
        ),
        array(
            "type" => "textfield",
            "heading" => __('Info Window Max Width', 'aqua'),
            "param_name" => "infowidth",
            "value" => '200',
            "group" => __("Marker", 'aqua'),
            "description" => __('Set max width for info window', 'aqua')
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Map Type", 'aqua'),
            "param_name" => "type",
            "value" => array(
                "ROADMAP" => "ROADMAP",
                "HYBRID" => "HYBRID",
                "SATELLITE" => "SATELLITE",
                "TERRAIN" => "TERRAIN"
            ),
            "description" => __('Select the map type.', 'aqua')
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Style Template", 'aqua'),
            "param_name" => "style",
            "value" => array(
                "Default" => "",
                "Custom" => "custom",
                "Light Monochrome" => "light-monochrome",
                "Blue water" => "blue-water",
                "Midnight Commander" => "midnight-commander",
                "Paper" => "paper",
                "Red Hues" => "red-hues",
                "Hot Pink" => "hot-pink"
            ),
            "group" => __("Map Style", 'aqua'),
            "description" => 'Select your heading size for title.'
        ),
        array(
            "type" => "textarea_raw_html",
            "heading" => __('Custom Template', 'aqua'),
            "param_name" => "content",
            "value" => '',
            "group" => __("Map Style", 'aqua'),
            "description" => __('Get template from http://snazzymaps.com', 'aqua')
        ),
        array(
            "type" => "textfield",
            "heading" => __('Zoom', 'aqua'),
            "param_name" => "zoom",
            "value" => '13',
            "description" => __('zoom level of map, default is 13', 'aqua')
        ),
        array(
            "type" => "textfield",
            "heading" => __('Width', 'aqua'),
            "param_name" => "width",
            "value" => 'auto',
            "description" => __('Width of map without pixel, default is auto', 'aqua')
        ),
        array(
            "type" => "textfield",
            "heading" => __('Height', 'aqua'),
            "param_name" => "height",
            "value" => '350px',
            "description" => __('Height of map without pixel, default is 350px', 'aqua')
        ),
        array(
            "type" => "checkbox",
            "heading" => __('Scroll Wheel', 'aqua'),
            "param_name" => "scrollwheel",
            "value" => array(
                __("Yes, please", 'aqua') => true
            ),
            "group" => __("Controls", 'aqua'),
            "description" => __('If false, disables scrollwheel zooming on the map. The scrollwheel is disable by default.', 'aqua')
        ),
        array(
            "type" => "checkbox",
            "heading" => __('Pan Control', 'aqua'),
            "param_name" => "pancontrol",
            "value" => array(
                __("Yes, please", 'aqua') => true
            ),
            "group" => __("Controls", 'aqua'),
            "description" => __('Show or hide Pan control.', 'aqua')
        ),
        array(
            "type" => "checkbox",
            "heading" => __('Zoom Control', 'aqua'),
            "param_name" => "zoomcontrol",
            "value" => array(
                __("Yes, please", 'aqua') => true
            ),
            "group" => __("Controls", 'aqua'),
            "description" => __('Show or hide Zoom Control.', 'aqua')
        ),
        array(
            "type" => "checkbox",
            "heading" => __('Scale Control', 'aqua'),
            "param_name" => "scalecontrol",
            "value" => array(
                __("Yes, please", 'aqua') => true
            ),
            "group" => __("Controls", 'aqua'),
            "description" => __('Show or hide Scale Control.', 'aqua')
        ),
        array(
            "type" => "checkbox",
            "heading" => __('Map Type Control', 'aqua'),
            "param_name" => "maptypecontrol",
            "value" => array(
                __("Yes, please", 'aqua') => true
            ),
            "group" => __("Controls", 'aqua'),
            "description" => __('Show or hide Map Type Control.', 'aqua')
        ),
        array(
            "type" => "checkbox",
            "heading" => __('Street View Control', 'aqua'),
            "param_name" => "streetviewcontrol",
            "value" => array(
                __("Yes, please", 'aqua') => true
            ),
            "group" => __("Controls", 'aqua'),
            "description" => __('Show or hide Street View Control.', 'aqua')
        ),
        array(
            "type" => "checkbox",
            "heading" => __('Over View Map Control', 'aqua'),
            "param_name" => "overviewmapcontrol",
            "value" => array(
                __("Yes, please", 'aqua') => true
            ),
            "group" => __("Controls", 'aqua'),
            "description" => __('Show or hide Over View Map Control.', 'aqua')
        )
    )
));