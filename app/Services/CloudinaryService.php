<?php

namespace App\Services;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class CloudinaryService
{
    /**
     * Upload an image to Cloudinary
     *
     * @param UploadedFile|string|null $image The image to upload
     * @param string $folder The folder to upload to
     * @param array $options Additional upload options
     * @return string|null The URL of the uploaded image or null if upload failed
     */
    public function uploadImage($image, string $folder = 'hotel', array $options = []): ?string
    {
        // If no image is provided, return null
        if (!$image) {
            return null;
        }

        try {
            // Set default options
            $defaultOptions = [
                'folder' => $folder,
            ];

            // Merge with custom options
            $uploadOptions = array_merge($defaultOptions, $options);

            // Upload the image
            $result = Cloudinary::upload(
                $image instanceof UploadedFile ? $image->getRealPath() : $image,
                $uploadOptions
            );

            // Return the secure URL
            return $result->getSecurePath();
        } catch (\Exception $e) {
            // Log the error
            Log::error('Cloudinary upload failed: ' . $e->getMessage());
            
            // Return null on failure
            return null;
        }
    }

    /**
     * Delete an image from Cloudinary
     *
     * @param string $publicId The public ID of the image
     * @return bool Whether the deletion was successful
     */
    public function deleteImage(string $publicId): bool
    {
        try {
            Cloudinary::destroy($publicId);
            return true;
        } catch (\Exception $e) {
            Log::error('Cloudinary deletion failed: ' . $e->getMessage());
            return false;
        }
    }
}