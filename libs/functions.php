<?php
function control_input($data)
{
    return htmlspecialchars(stripslashes(trim($data)));
}


function saveImage($file)
{
    $message = "";
    $uploadOK = 1;
    $fileTempPath = $file["tmp_name"];
    $fileName = $file["name"];
    $fileSize = $file["size"];
    $maxFileSizeMB = 1;
    $maxFileSizeBytes = $maxFileSizeMB * 1024 * 1024;
    $allowedExtensions  = array("jpg", "jpeg", "png");
    $uploadFolder = "./img/";

    //Dosya boyutu kontrolü
    if ($fileSize > $maxFileSizeBytes) {
        $message = "Dosya boyutu fazla";
        $uploadOK = 0;
    }

    // Dosya uzantısı kontrolü
    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
    if (!in_array($fileExtension, $allowedExtensions)) {
        $message .= "Dosya uzantısı kabul edilemiyor. Kabul edilen uzantılar: " . implode(", ", $allowedExtensions);
        $uploadOK = 0;
    }


    // Yeni dosya adı oluşturma
    $uniqueFilename = md5(time() . $fileName) . '.' . $fileExtension;
    $targetPath = $uploadFolder . $uniqueFilename;

    // Dosyayı kaydetme
    if ($uploadOK == 1) {
        if (move_uploaded_file($fileTempPath, $targetPath)) {
            $message .= "Dosya başarıyla yüklendi.";
        } else {
            $message .= "Dosya yüklenemedi.";
        }
    }

    return array(
        "isSuccess" => $uploadOK,
        "message" => $message,
        "image" => $uniqueFilename
    );
}
