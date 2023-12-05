<?php
$target_dir = "./uploads/";
$uploadFormat = $_POST["uploadFormat"];
$compressionFormat = $_POST["compressionFormat"];
$message = "";
$downloadButton = "";

if (isset($_POST["submit"])) {
    $target_upload = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $filename = pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_FILENAME);
    $target_compressed = $target_dir . $filename . "." . $compressionFormat;

    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_upload)) {
        switch ($compressionFormat) {
            case 'mp3':
                system("ffmpeg -i $target_upload -c:a libmp3lame $target_compressed");
                break;
            case 'wma':
                system("ffmpeg -i $target_upload -c:a wmav2 $target_compressed");
                break;
            case 'flac':
                system("ffmpeg -i $target_upload -c:a flac $target_compressed");
                break;
            case 'ogg':
                system("ffmpeg -i $target_upload -c:a libvorbis $target_compressed");
                break;
            case 'aac':
                system("ffmpeg -i $target_upload -c:a aac $target_compressed");
                break;
            default:
                echo "Unsupported compression format.";
                exit;
        }

        $message = "File berhasil diupload dan diubah menjadi $filename.$compressionFormat.";

        unlink($target_upload);

        $downloadButton = '<a href="' . $target_compressed . '" download class="download-button">
                            Download Hasil Konversi
                        </a>';
    } else {
        $message = "Gagal mengupload file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Upload and Convert Audio File</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Yonvert</h1>
    </header>
    <div class="container">
        <h2>Convert Audio File</h2>
        <div>
            <?php echo $message; ?>
            <?php echo $downloadButton; ?>
        </div>
    </div>
    <div class="center-button">
        <a href="index.html" style="text-decoration: none;">
            <button>
                Kembali ke Index
            </button>
        </a>
    </div>
</body>
</html>