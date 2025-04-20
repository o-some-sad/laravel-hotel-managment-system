<?php

use App\Services\CloudinaryService;

if (!function_exists('upload_image')) {
    /**
     * Upload an image to Cloudinary
     *
     * @param mixed $image The image to upload
     * @param string $folder The folder to upload to
     * @param array $options Additional upload options
     * @return string|null The URL of the uploaded image or null if upload failed
     */
    function upload_image($image, string $folder = 'hotel', array $options = []): ?string
    {
        return app(CloudinaryService::class)->uploadImage($image, $folder, $options);
    }
}