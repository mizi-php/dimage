<?php

namespace Mizi\DImage;

trait TraitDImageSet
{
    /** Define a qualidade da imagem para arquivos JPG */
    function jpgQuality(int $quality): static
    {
        $this->jpgQuality = num_interval($quality, 0, 100);
        return $this;
    }

    /** Define um nome para o arquivo */
    function rename(string $name): static
    {
        return $this->name($name);
    }

    /** Define um nome para o arquivo */
    function name(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    /** Define a cor base da imagem */
    function color(string|array $color): static
    {
        $this->color = $this->normalizeColor($color);
        return $this;
    }
}
