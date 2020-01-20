<?php

return [
    'layout' => env('CW_LAYOUT', 'layouts.app'),
    'views' => env('CW_VIEWS', 'integration::'),
    'services' => [
        ['slug' => 'UserService', 'name' => 'Usuarios']
    ]
];
