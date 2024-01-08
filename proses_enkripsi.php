<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Proses enkripsi disini

    // Ambil file yang diupload
    $file = $_FILES["file"]["tmp_name"];
    $key = strtoupper($_POST["key"]); // Ubah kunci menjadi huruf besar
    $output_file = "hasil_enkripsi.txt"; // Nama file hasil enkripsi

    // Baca isi file
    $plaintext = file_get_contents($file);

    // Inisialisasi
    $encrypted_text = "";
    $key_index = 0;

    // Enkripsi
    for ($i = 0; $i < strlen($plaintext); $i++) {
        $char = strtoupper($plaintext[$i]);

        if (ctype_alpha($char)) {
            // Enkripsi hanya dilakukan untuk huruf alfabet
            $key_char = $key[$key_index % strlen($key)];
            $key_index++;

            $encrypted_char = chr(((ord($char) - 65 + ord($key_char) - 65) % 26) + 65);
            $encrypted_text .= ($char === strtolower($char)) ? strtolower($encrypted_char) : $encrypted_char;
        } else {
            // Jika karakter bukan huruf alfabet, biarkan tidak terenkripsi
            $encrypted_text .= $char;
        }
    }

    // Simpan hasil enkripsi ke dalam file
    file_put_contents($output_file, $encrypted_text);

    // Tampilkan hasil enkripsi
    echo "<h2>Hasil Enkripsi:</h2>";
    echo "<pre>$encrypted_text</pre>";

    // Berikan link untuk mendownload hasil
    echo "<a href=\"download.php?file=$output_file\">Download Hasil Enkripsi</a>";
}
?>