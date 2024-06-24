<?php
namespace App\Utils;

use Cloudinary\Cloudinary;
use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;
use Exception;

class CloudinaryHandler
{
    private $cloudinary;

    public function __construct()
    {
        $config = Configuration::instance([
            'cloud' => [
                'cloud_name' => 'dnwemzbtm',
                'api_key'    => '375881354516285',
                'api_secret' => 'uwXBgStwPU_XoC0WyPm0QfdKrCY',
            ],
            'url' => [
                'secure' => true
            ]
        ]);
        $this->cloudinary = new Cloudinary($config);
    }

    public function uploadImage($file)
    {
        try {
            $uploadResult = (new UploadApi())->upload($file);
            return $uploadResult['secure_url'];
        } catch (Exception $e) {
            throw new Exception('Error uploading image to Cloudinary: ' . $e->getMessage());
        }
    }
}
?>
