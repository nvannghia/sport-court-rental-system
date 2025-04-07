<?php
namespace App\Utils;
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
class CaptchaUtils {
    public static function generateCaptchaCode($length = 6) {
        $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz23456789';
        return substr(str_shuffle($chars), 0, $length);
    }

    public static function createCaptchaImage() {
        $_SESSION['captcha_code'] = self::generateCaptchaCode();
    
        $width = 150;
        $height = 50;
    
        $image = imagecreatetruecolor($width, $height);
        $bgColor = imagecolorallocate($image, 255, 255, 255);
        $textColor = imagecolorallocate($image, 0, 0, 0);
        $lineColor = imagecolorallocate($image, 200, 200, 200); // Màu xám nhạt cho đường gạch
    
        // Tô nền trắng
        imagefilledrectangle($image, 0, 0, $width, $height, $bgColor);
    
        // Thêm các đường gạch ngẫu nhiên
        for ($i = 0; $i < 6; $i++) { // Số lượng đường gạch có thể điều chỉnh
            imageline(
                $image,
                rand(0, $width), rand(0, $height), // Điểm bắt đầu
                rand(0, $width), rand(0, $height), // Điểm kết thúc
                $lineColor
            );
        }
    
        $font = dirname(__FILE__) . '../../../public/fonts/arial.ttf';  

        imagettftext($image, 22, rand(-10, 10), 20, 35, $textColor, $font, $_SESSION['captcha_code']);
    
        return $image;
    }    

    public static function validateCaptcha($input) {
        return isset($_SESSION['captcha_code']) && strcasecmp($input, $_SESSION['captcha_code']) === 0;
    }
}
?>
