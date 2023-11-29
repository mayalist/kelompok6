<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $targetDir = 'uploads/';
    $targetFile = $targetDir . basename($_FILES['file']['name']);
    $fileType = pathinfo($targetFile, PATHINFO_EXTENSION);

    // Check if the file is an MP3 file
    if ($fileType !== 'mp3') {
        echo 'Invalid file format. Please choose an MP3 file.';
        exit;
    }

    // Get the selected format
    $outputFormat = $_POST['format'];

    // Perform conversion here
    // You need to implement the logic to convert MP3 to the selected format

    // For demonstration purposes, let's just move the uploaded file to the uploads folder
    if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
        echo 'File has been uploaded and converted to ' . $outputFormat . '.';

        // Generate download link
        $downloadLink = 'downloads/' . pathinfo($targetFile, PATHINFO_FILENAME) . '.' . $outputFormat;
        copy($targetFile, $downloadLink);

        echo '<br><a href="' . $downloadLink . '" download>Download Converted File</a>';
    } else {
        echo 'Error uploading file.';
    }
}
?>
