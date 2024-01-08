<!-- download.php -->
<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Proses download disini

    $file_name = $_GET["file"];

    // Tentukan header untuk file yang akan didownload
    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=$file_name");
    readfile($file_name);
}
?>