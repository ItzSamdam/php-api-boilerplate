<?php

namespace Utils;

use Cloudinary\Cloudinary;
use Cloudinary\Configuration\Configuration;
use Config\Config;

class CloudinaryUploader
{
    private $cloudinary;

    public function __construct()
    {
        // Set up Cloudinary configuration
        Configuration::instance([
            'cloud' => [
                'cloud_name' => Config::getCloudName(),
                'api_key' => Config::getCloudApiKey(),
                'api_secret' => Config::getCloudApiSecret()
            ]
        ]);

        $this->cloudinary = new Cloudinary();
    }

    /**
     * Upload a file (image, video, or other) to Cloudinary.
     *
     * @param string $filePath
     * @param string $folderPath
     * @param string|null $resourceType 'image', 'video', or 'auto'
     * @return array|null
     * @throws \Exception
     */
    public function upload($filePath, $folderPath = 'uploads', $resourceType = null): array|null
    {
        // Validate file existence
        if (!file_exists($filePath) || !is_file($filePath)) {
            throw new \Exception('File not found: ' . $filePath);
        }

        // File size limit (5MB)
        if (filesize($filePath) > 5 * 1024 * 1024) {
            throw new \Exception('File size exceeds the limit of 5MB.');
        }

        // Determine resource type if not provided
        if ($resourceType === null) {
            $mimeType = mime_content_type($filePath);
            if (str_starts_with($mimeType, 'image/')) {
                $resourceType = 'image';
            } elseif (str_starts_with($mimeType, 'video/')) {
                $resourceType = 'video';
            } else {
                $resourceType = 'auto';
            }
        }

        // Additional validation for images
        if ($resourceType === 'image') {
            if (!getimagesize($filePath)) {
                throw new \Exception('The file is not a valid image.');
            }
            $fileType = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
            if (!in_array($fileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                throw new \Exception('Invalid image type. Only JPG, JPEG, PNG, and GIF are allowed.');
            }
        }

        // Upload to Cloudinary
        $options = [
            'folder' => $folderPath,
            'quality' => 'auto',
        ];
        if ($resourceType !== 'image') {
            $options['resource_type'] = $resourceType;
        }

        $result = $this->cloudinary->uploadApi()->upload($filePath, $options);

        return $result ? [
            'url' => $result['secure_url'],
            'public_id' => $result['public_id']
        ] : null;
    }

    public function deleteImage($publicId): bool
    {
        try {
            $this->cloudinary->uploadApi()->destroy($publicId);
            return true;
        } catch (\Exception $e) {
            throw new \Exception('Error deleting image: ' . $e->getMessage());
        }
    }
}
