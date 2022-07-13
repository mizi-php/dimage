<?php

namespace Mizi\DImage;

use Exception;

trait TraitDImageNormalize
{
    /** Retorna uma extensão referente a uma veriavel */
    protected function normalizeExtension(string $ex): string
    {
        $ex = mb_strtolower($ex);

        $result = match ($ex) {
            'jpe', 'jpg', 'jpeg', 'bmp', 'png', 'webp', 'gif' => $ex,
            default => null
        };

        if (!$result)
            throw new Exception("Extenção de imagem [$ex] não suportada");

        return $result;
    }

    /** Normaliza uma variavel de cores */
    protected function normalizeColor(string|array $color): array
    {
        if (!is_array($color)) {
            $color = colorRGB($color);
            $color = explode(',', $color);
            $color = [
                $color[0], $color[1], $color[2],
            ];
        }
        return $color;
    }
}
