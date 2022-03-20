<?php

namespace App\Core;

class Source
{
    private $cssDirUri;
    private $imgDirUri;
    private $jsDirUri;

    public function __construct(
        string $cssDirUri,
        string $imgDirUri,
        string $jsDirUri
    ) {
        $this->cssDirUri = $cssDirUri;
        $this->imgDirUri = $imgDirUri;
        $this->jsDirUri  = $jsDirUri;
    }

    public function to($target, $ext="")
    {
        if ($ext != "") {
            $prop = "{$ext}DirUri";
            return $this->{$prop} . $target . ".{$ext}";
        } else {
            return BASE_URL . $target;
        }
    }
}
