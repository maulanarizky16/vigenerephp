<?php

require_once 'vendor/autoload.php';

use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;

// Fungsi untuk enkripsi Vigenere
function vigenereEncrypt($text, $key)
{
    $result = '';
    $textLength = strlen($text);
    $keyLength = strlen($key);

    for ($i = 0; $i < $textLength; $i++) {
        $result .= chr((ord($text[$i]) + ord($key[$i % $keyLength])) % 256);
    }

    return $result;
}

// Fungsi untuk dekripsi Vigenere
function vigenereDecrypt($text, $key)
{
    $result = '';
    $textLength = strlen($text);
    $keyLength = strlen($key);

    for ($i = 0; $i < $textLength; $i++) {
        $result .= chr((ord($text[$i]) - ord($key[$i % $keyLength]) + 256) % 256);
    }

    return $result;
}

// Fungsi untuk membaca teks dari file Word
function readWordFile($filePath)
{
    $phpWord = IOFactory::load($filePath);
    $allText = '';

    foreach ($phpWord->getSections() as $section) {
        foreach ($section->getElements() as $element) {
            if ($element instanceof \PhpOffice\PhpWord\Element\TextRun) {
                foreach ($element->getElements() as $text) {
                    if ($text instanceof \PhpOffice\PhpWord\Element\Text) {
                        $allText .= $text->getText();
                    }
                }
            }
        }
    }

    return $allText;
}

// Fungsi untuk menyimpan teks ke file Word
function saveToWordFile($filePath, $text)
{
    $phpWord = new PhpWord();
    $section = $phpWord->addSection();
    $section->addText($text);

    $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
    $objWriter->save($filePath);
}

// Contoh penggunaan
$wordFilePath = 'path/to/your/document.docx';
$key = 'yourEncryptionKey';

// Baca teks dari file Word
$originalText = readWordFile($wordFilePath);

// Enkripsi teks
$encryptedText = vigenereEncrypt($originalText, $key);

// Simpan teks terenkripsi ke dalam file Word
$encryptedWordFilePath = 'path/to/your/encrypted/document.docx';
saveToWordFile($encryptedWordFilePath, $encryptedText);

echo "Enkripsi berhasil! Hasil disimpan di $encryptedWordFilePath\n";

// Dekripsi teks (contoh)
$decryptedText = vigenereDecrypt($encryptedText, $key);
echo "Hasil dekripsi:\n$decryptedText\n";