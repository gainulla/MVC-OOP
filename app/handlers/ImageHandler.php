<?php

namespace App\Handlers;

class ImageHandler extends Handler
{
    public function src($uploads_path) {
        $filename = $uploads_path . '/' . $this->params(0);

        if (file_exists($filename)) {
            $ext = substr(strrchr( $filename, '.'), 1);
            $fs = filesize($filename);
        }

        header("Content-Type: image/{$ext}");
        header('Content-Length: ' . $fs);
        readfile($filename);
    }

    public function resize($src, $w, $h)
    {
        
    }
}

?>