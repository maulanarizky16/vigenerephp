<!-- proses_deskripsi.php -->
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Proses dekripsi disini

    // Ambil file yang diupload
    $file = $_FILES["file"]["tmp_name"];
    $key = strtoupper($_POST["key"]); // Ubah kunci menjadi huruf besar
    $output_file = "hasil_dekripsi.txt"; // Nama file hasil dekripsi

    // Baca isi file
    $ciphertext = file_get_contents($file);

    // Inisialisasi
    $decrypted_text = "";
    $key_index = 0;

    // Dekripsi
    for ($i = 0; $i < strlen($ciphertext); $i++) {
        $char = strtoupper($ciphertext[$i]);

        if (ctype_alpha($char)) {
            // Dekripsi hanya dilakukan untuk huruf alfabet
            $key_char = $key[$key_index % strlen($key)];
            $key_index++;

            $decrypted_char = chr(((ord($char) - 65 - (ord($key_char) - 65) + 26) % 26) + 65);
            $decrypted_text .= ($char === strtolower($char)) ? strtolower($decrypted_char) : $decrypted_char;
        } else {
            // Jika karakter bukan huruf alfabet, biarkan tidak terdekripsi
            $decrypted_text .= $char;
        }
    }

    // Simpan hasil dekripsi ke dalam file
    file_put_contents($output_file, $decrypted_text);

    // Tampilkan hasil dekripsi
    echo "<h2>Hasil Dekripsi:</h2>";
    echo "<pre>$decrypted_text</pre>";

    // Berikan link untuk mendownload hasil
    echo "<a href=\"download.php?file=$output_file\">Download Hasil Dekripsi</a>";
}
?>