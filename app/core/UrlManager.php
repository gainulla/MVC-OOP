<?php

namespace App\Core;

class UrlManager
{
    private $cssDirUri;
    private $imgDirUri;
    private $jsDirUri;
    private $allowImgExt;

    public function __construct(
        string $cssDirUri,
        string $imgDirUri,
        string $jsDirUri,
        array $allowImgExt
    )
    {
        $this->cssDirUri = $cssDirUri;
        $this->imgDirUri = $imgDirUri;
        $this->jsDirUri  = $jsDirUri;
        $this->allowImgExt = $allowImgExt;
    }

    public function for(string $target, string $fileExt="")
    {
        if (in_array($fileExt, $this->allowImgExt)) {
            $dir = 'img';
        } else {
            $dir = $fileExt;
        }

        switch ($dir) {
            case 'img':
                return $this->imgDirUri . $target. ".$fileExt";
            case 'css':
                return $this->cssDirUri . $target . ".$dir";
            case 'js':
                return $this->jsDirUri . $target . ".$dir";
            default:
                return BASE_URL . ltrim($target, '/');
        }
    }
}
