<?php

namespace Mizi\DImage;

use GdImage;

trait TraitDImageInit
{
    /** Objeto de Imagem */
    protected GdImage $gd;

    /** Cor de fundo da imagem */
    protected array $color = ['255', '255', '255'];

    /** Tamanho da imagem */
    protected array $size = [1, 1];

    /** Extensão da imagem */
    protected string $extension = 'jpg';

    /** Qualidade das imagens JPG */
    protected int $jpgQuality = 70;

    /** Nome da imagem (para salvar) */
    protected string $name;

    /** Caminho fisico da imagem */
    protected string $path;

    protected function __construct()
    {
    }
}
