<?php

namespace App\Core;

class UrlManager
{
    private $cssDirUri;
    private $imgDirUri;
    private $jsDirUri;
    private $allowImgExt;

    public function __construct(
        array $assetsUri,
        array $allowImgExt
    )
    {
		$required = ['css_dir_uri','js_dir_uri','img_dir_uri'];
		extract($assetsUri);

        foreach ($required as $uri) {
			if (!isset($uri)) {
				throw new \InvalidArgumentException("Required parameter is missing!");
			}
		}

        $this->cssDirUri = $css_dir_uri;
        $this->jsDirUri  = $js_dir_uri;
        $this->imgDirUri = $img_dir_uri;
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
