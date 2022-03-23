<?php

namespace App\Core;

class UrlManager
{
    private $cssDirUri;
    private $imgDirUri;
    private $jsDirUri;

    public function __construct(string $cssDirUri, string $imgDirUri, string $jsDirUri) {
        $this->cssDirUri = $cssDirUri;
        $this->imgDirUri = $imgDirUri;
        $this->jsDirUri  = $jsDirUri;
    }

    public function for($target, $ext="")
    {
        if ($ext != "") {
            $prop = "{$ext}DirUri";
            return $this->{$prop} . $target . ".{$ext}";
        } else {
            return BASE_URL . $target;
        }
    }
}
