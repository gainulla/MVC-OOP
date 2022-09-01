<?php

namespace App\Handlers;

class ImageHandler extends Handler
{
    public function src($uploadsPath) {
        $filename = $uploadsPath . '/' . $this->params(0);

        if (file_exists($filename)) {
            $ext = substr(strrchr( $filename, '.'), 1);
            $fs = filesize($filename);
        }

        header("Content-Type: image/{$ext}");
        header('Content-Length: ' . $fs);
        readfile($filename);
    }

    public function upload($uploadsPath)
    {
        if (isset($_POST['file'])) {
            $file = $_POST['file'];

            $dataParts = explode(";base64,", $file);
            $ext = explode("/", $dataParts[0])[1];

            $imageCode = str_replace(' ', '+', $dataParts[1]);
            $base64 = base64_decode($imageCode);
            $image = uniqid() . '.' . $ext;
            $filename = $uploadsPath . '/' . $image;

            file_put_contents($filename, $base64);

            echo $image;
        }
    }
}

?>