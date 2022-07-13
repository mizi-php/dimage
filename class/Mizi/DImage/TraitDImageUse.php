<?php

namespace Mizi\DImage;

use Mizi\Dir;
use Mizi\File;
use Mizi\DImage;
use Error;
use Mizi\Response\InstanceResponseDImage;

trait TraitDImageUse
{
    /** Salva a imagem em um arquivo */
    function save(?string $path = null): static
    {
        $path = $path ?? $this->path;

        if (is_null($path))
            throw new Error('É preciso definir um caminho para salvar o arquivo');

        $nameFile = $this->getName(true);
        $path = $path . '/' . $nameFile;
        File::ensure_extension($path, $this->extension);

        $file = path($path);
        Dir::create($file);
        $this->path = $path;

        match ($this->extension) {
            'jpe', 'jpg', 'jpeg', 'bmp' => imagejpeg($this->gd, $file, $this->jpgQuality),
            'png' => imagepng($this->gd, $file, 9),
            'gif' => imagegif($this->gd, $file),
            'webp' => imagewebp($this->gd, $file)
        };

        return $this;
    }

    /** Retorna uma copia do objeto de imagem atual*/
    function copy(): DImage
    {
        return clone ($this);
    }

    /** Envia a imagem como resposta da requisição atual */
    function send(?int $status = null): never
    {
        (new InstanceResponseDImage($this))->send($status);
    }
}