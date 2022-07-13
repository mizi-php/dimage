<?php

namespace Mizi\DImage;

use GdImage;

trait TraitDImageGet
{
    /** Retorna o nome da imagem */
    function getName(bool $ex = false): string
    {
        return $ex ? "$this->name.$this->extension" : $this->name;
    }

    /** Retorna o caminho da imagem no disco */
    function getPath(): ?string
    {
        return $this->path;
    }

    /** Retorna a imagem GD gerada pela classe */
    function getGd(): GdImage
    {
        return $this->gd;
    }

    /** Retorna o array de dimensão da imagem */
    function getSize(): array
    {
        return $this->size;
    }

    /** Retorna a largura da imagem */
    function getWidth(): int
    {
        return $this->size[0];
    }

    /** Retorna a altura da imagem */
    function getHeight(): int
    {
        return $this->size[1];
    }

    /** Retorna a extensao da imagem */
    function getExtension(): string
    {
        return $this->extension;
    }

    /** Retorna o tamanho da imagem em MB */
    function getSizeFile(): float
    {
        return num_format(strlen($this->getBin()) / (1024 * 1024), 2, 1);
    }

    /** Captura o Hash Md5 gerado pelo binario da imagem */
    function getHash(): string
    {
        return md5($this->getBin());
    }

    /** Retorna o binario da imagem */
    function getBin(): string
    {
        ob_start();
        match ($this->extension) {
            'jpe', 'jpg', 'jpeg', 'bmp' => imagejpeg($this->gd, null, $this->jpgQuality),
            'png' => imagepng($this->gd, null, 9),
            'gif' => imagegif($this->gd),
            'webp' => imagewebp($this->gd),
        };
        $bin = ob_get_contents();
        ob_end_clean();
        return $bin;
    }
}
