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

    public function for(string $name, string $fileExt="")
    {
        if (in_array($fileExt, $this->allowImgExt)) {
            $dir = 'img';
        } else {
            // e.g. example.js directory is js
            $dir = $fileExt;
        }

        switch ($dir) {
            case 'img':
                return $this->imgDirUri . $name. ".$fileExt";
            case 'css':
                return $this->cssDirUri . $name . ".$fileExt";
            case 'js':
                return $this->jsDirUri . $name . ".$fileExt";
            // controller/action
            default:
                return BASE_URL . ltrim($name, '/');
        }
    }
}
