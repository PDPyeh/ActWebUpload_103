<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar File</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-3xl mx-auto bg-white shadow-md rounded-lg p-8">
        <h2 class="text-2xl font-bold mb-4">Daftar File yang Diunggah</h2>

        <?php
        // Handle file deletion
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
            $fileToDelete = basename($_POST['delete']); // amankan nama file
            $filePath = "uploads/" . $fileToDelete;

            if (file_exists($filePath)) {
                unlink($filePath);
                echo "<p class='text-green-600 mb-4'>File <strong>$fileToDelete</strong> berhasil dihapus.</p>";
            } else {
                echo "<p class='text-red-600 mb-4'>File tidak ditemukan.</p>";
            }
        }
        ?>

        <ul class="space-y-4">
        <?php
        $dir = "uploads/";
        if (is_dir($dir)) {
            $files = array_diff(scandir($dir), array('.', '..'));
            if (count($files) > 0) {
                foreach ($files as $file) {
                    $path = $dir . $file;
                    $ext = pathinfo($file, PATHINFO_EXTENSION);
                    $isImage = in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif', 'webp']);

                    echo "<li class='bg-gray-50 p-4 rounded shadow-sm'>
                            <div class='flex items-center justify-between'>
                                <span class='font-medium break-all'>$file</span>
                                <div class='space-x-2'>
                                    <a href='$path' target='_blank' class='text-blue-600 hover:underline'>Lihat</a>
                                    <a href='$path' download class='text-green-600 hover:underline'>Download</a>
                                    <form method='post' class='inline' onsubmit=\"return confirm('Yakin ingin menghapus file ini?');\">
                                        <input type='hidden' name='delete' value='$file'>
                                        <button type='submit' class='text-red-600 hover:underline'>Hapus</button>
                                    </form>
                                </div>
                            </div>";

                    if ($isImage) {
                        echo "<div class='mt-3'><img src='$path' alt='$file' class='max-w-xs rounded border'></div>";
                    }

                    echo "</li>";
                }
            } else {
                echo "<li>Tidak ada file yang diunggah.</li>";
            }
        } else {
            echo "<li>Folder uploads tidak ditemukan.</li>";
        }
        ?>
        </ul>

        <a href="index.html" class="mt-6 inline-block text-purple-600 hover:underline">← Kembali ke Upload</a>
    </div>
</body>
</html>
