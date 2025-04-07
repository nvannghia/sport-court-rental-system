<?php
require_once '../../vendor/autoload.php';
use App\Utils\CaptchaUtils;

$captchaImage  = CaptchaUtils::createCaptchaImage();

// Convert image to base64 send to AJAX request
ob_start();
imagepng($captchaImage );
$captchaData = ob_get_contents();
ob_end_clean();
imagedestroy($captchaImage);

echo base64_encode($captchaData);
?>