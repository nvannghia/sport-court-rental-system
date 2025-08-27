<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

// Kiểm tra nếu có file được upload
if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {

    $tempFile = $_FILES['file']['tmp_name'];
    $ownerID = $_SESSION["userInfo"]["field_owner"]["OwnerID"];
    $targetDirectory = "uploads/description-image/$ownerID/";

    // Tạo thư mục nếu chưa tồn tại
    if (!file_exists($targetDirectory)) {
        mkdir($targetDirectory, 0777, true);
    }

    $fileName = uniqid() . '_' . $_FILES['file']['name']; // Tạo tên file duy nhất
    $targetFile = $targetDirectory . $fileName;

    // Di chuyển file từ thư mục tạm sang thư mục uploads
    if (move_uploaded_file($tempFile, $targetFile)) {
        // Trả về đường dẫn của file ảnh để TinyMCE sử dụng
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'
            || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

        $host = $_SERVER['HTTP_HOST']; // domain + port (nếu có)

        $relativePath = str_replace($_SERVER['DOCUMENT_ROOT'], '', $targetFile);

        // Full URL
        echo json_encode([
            'location' => $protocol. $host ."/sport-court-rental-system/app/utils/". $relativePath
        ]);
    } else {
        // Báo lỗi nếu không thể di chuyển file
        echo json_encode(['error' => 'Failed to move uploaded file']);
    }
} else {
    // Báo lỗi nếu có lỗi trong quá trình upload
    echo json_encode(['error' => 'Upload failed']);
}
