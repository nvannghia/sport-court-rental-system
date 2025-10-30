<?php

namespace App\Utils;

use Cloudinary\Cloudinary;
use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;
use Exception;
use Dotenv\Dotenv;

class CloudinaryService
{
    private $cloudinary;

    public function __construct()
    {
        $configuration =  Configuration::instance([
            'cloud' => [
                'cloud_name' => 'dnwemzbtm',
                'api_key'    => '375881354516285',
                'api_secret' => 'uwXBgStwPU_XoC0WyPm0QfdKrCY'
            ],
            'url' => [
                'secure' => true
            ]
        ]);

        $this->cloudinary = new Cloudinary($configuration);
    }

    public function uploadFile($filePath, $options = [])
    {
        try {
            // Tải lên tệp tin lên Cloudinary
            $result = (new UploadApi())->upload($filePath, $options);
            return $result;
        } catch (Exception $e) {
            throw new Exception("Upload failed: " . $e->getMessage());
        }
    }
}
