<!-- deskripsi.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dekripsi</title>
</head>
<body>
    <h2>Dekripsi</h2>
    <form action="proses_deskripsi.php" method="post" enctype="multipart/form-data">
        <label for="file">Upload File:</label>
        <input type="file" name="file" required>
        <br>
        <label for="key">Masukkan Key:</label>
        <input type="text" name="key" required>
        <br>
        <button type="submit">Dekripsi</button>
    </form>
</body>
</html>