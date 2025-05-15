<?php

namespace Utils;

use Cloudinary\Cloudinary;
use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;
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

    public function uploadImage($filePath)
    {
        $upload = new UploadApi();
        $result = $upload->upload($filePath, [
            'folder' => 'uploads'
        ]);

        return $result['secure_url'] ?? null;
    }
}
