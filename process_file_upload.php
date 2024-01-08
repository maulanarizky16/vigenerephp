<?php
// process_file_upload.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pastikan file diunggah dengan benar
    if (isset($_FILES["uploadedFile"]) && $_FILES["uploadedFile"]["error"] == UPLOAD_ERR_OK) {
        $file = $_FILES["uploadedFile"]["tmp_name"];

        // Tentukan jenis file berdasarkan ekstensinya
        $fileExtension = strtolower(pathinfo($_FILES["uploadedFile"]["name"], PATHINFO_EXTENSION));

        // Inisialisasi variabel untuk menampung teks
        $text = '';

        // Load file dan ambil teks berdasarkan jenis file
        if ($fileExtension == 'pdf') {
            // Membaca teks dari file PDF menggunakan mPDF
            require 'vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf();
            $text = $mpdf->getTextFromPDF($file);
        } elseif (in_array($fileExtension, ['doc', 'docx'])) {
            // Load file Word menggunakan PhpWord
            require 'vendor/autoload.php';
            $phpWord = \PhpOffice\PhpWord\IOFactory::load($file);

            // Mendapatkan teks dari semua paragraf
            foreach ($phpWord->getSections() as $section) {
                foreach ($section->getElements() as $element) {
                    if ($element instanceof \PhpOffice\PhpWord\Element\TextRun) {
                        foreach ($element->getElements() as $textRun) {
                            $text .= $textRun->getText();
                        }
                    }
                }
            }
        }

        // Tampilkan teks
        echo "<h2>Text from Uploaded File:</h2>";
        echo "<pre>$text</pre>";
    } else {
        echo "Error uploading file.";
    }
} else {
    // Redirect to the form if accessed directly
    header("Location: index.php");
    exit();
}