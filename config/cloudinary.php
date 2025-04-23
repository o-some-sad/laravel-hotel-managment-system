<?php

// return [
//     'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
//     'api_key' => env('CLOUDINARY_API_KEY'),
//     'api_secret' => env('CLOUDINARY_API_SECRET'),
//     'secure' => env('CLOUDINARY_SECURE', true)
// ];
return [
    'cloud' => [
        'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
        'api_key'    => env('CLOUDINARY_KEY'),
        'api_secret' => env('CLOUDINARY_SECRET'),
    ],
    'url' => [
        'secure' => env('CLOUDINARY_SECURE', true),
    ],
];
