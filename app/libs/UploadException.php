<?php

namespace App\Libs;

class UploadException extends \Exception {

    public function __construct($code) {
        $err_message = $this->codeToMessage($code);
        parent::__construct($err_message, $code);
    }

    private function codeToMessage($code) {
        switch ($code) {
            case UPLOAD_ERR_INI_SIZE:
                $err = 'The uploaded file exceeds the upload_max_filesize directive in php.ini.';
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $err = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.';
                break;
            case UPLOAD_ERR_PARTIAL:
                $err = 'The uploaded file was only partially uploaded.';
                break;
            case UPLOAD_ERR_NO_FILE:
                $err = 'No file was uploaded.';
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $err = 'Missing a temporary folder.';
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $err = 'Failed to write file to disk.';
                break;
            case UPLOAD_ERR_EXTENSION:
                $err = 'A PHP extension stopped the file upload.';
                break;
        }

        return $err;
    }

}
