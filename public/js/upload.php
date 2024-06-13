<?php
if ($_FILES) {
    $file = $_FILES['file'];
    $uploadDir = 'uploads/';
    $uploadFile = $uploadDir . basename($file['name']);

    if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
        $location = $uploadFile;
        echo json_encode(['location' => $location]);
    } else {
        header("HTTP/1.1 500 Internal Server Error");
        echo "Failed to upload file.";
    }
}
?>