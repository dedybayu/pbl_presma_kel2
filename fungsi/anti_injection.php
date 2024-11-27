<?php
function antiinjection($data)
{
    $data = stripslashes($data);
    $data = strip_tags($data);
    $data = htmlentities($data);
    $data = htmlspecialchars($data);
    $data = addslashes($data);
    return $data;
}

function antiinjection_files($files, $allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf'], $maxSizes = []) {
    $validatedFiles = [];

    // Tentukan batas ukuran default (1MB untuk gambar, 4MB untuk PDF)
    $defaultMaxSize = [
        'image' => 1 * 1024 * 1024,  // 1 MB untuk gambar
        'pdf' => 4 * 1024 * 1024     // 4 MB untuk PDF
    ];
    $maxSizes = array_merge($defaultMaxSize, $maxSizes);

    foreach ($files as $fieldName => $file) {
        // Skip jika file tidak diunggah
        if (empty($file['tmp_name'])) {
            $validatedFiles[$fieldName] = null;
            continue;
        }

        // Validasi nama file
        $file['name'] = preg_replace('/[^a-zA-Z0-9_\-\.]/', '', $file['name']);

        // Validasi ekstensi file
        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($fileExtension, $allowedExtensions)) {
            throw new Exception("Ekstensi file tidak diizinkan untuk field $fieldName: $fileExtension");
        }

        // Validasi ukuran file
        $maxSize = $fileExtension === 'pdf' ? $maxSizes['pdf'] : $maxSizes['image'];
        if ($file['size'] > $maxSize) {
            throw new Exception("Ukuran file terlalu besar untuk $fieldName: " . round($file['size'] / 1024, 2) . " KB");
        }

        // Tambahkan file yang valid
        $validatedFiles[$fieldName] = $file;
    }

    return $validatedFiles;
}


?>