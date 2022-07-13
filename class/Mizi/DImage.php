<?php

namespace Mizi;

use Error;
use Exception;
use Mizi\DImage\TraitDImageCalc;
use Mizi\DImage\TraitDImageEdit;
use Mizi\DImage\TraitDImageGet;
use Mizi\DImage\TraitDImageInit;
use Mizi\DImage\TraitDImageNormalize;
use Mizi\DImage\TraitDImageSet;
use Mizi\DImage\TraitDImageUse;

class DImage
{
    use TraitDImageSet;
    use TraitDImageUse;
    use TraitDImageGet;
    use TraitDImageInit;
    use TraitDImageEdit;
    use TraitDImageCalc;
    use TraitDImageNormalize;

    /** Cria um objeto DImage com base em um arquivo de upload */
    static function _upload(string $inputFileName, int $position = 0): DImage
    {
        $uploadListFiles = Request::file($inputFileName);

        if (
            empty($uploadListFiles)
            || !isset($uploadListFiles[$position])
            || $uploadListFiles[$position]['error']
        )
            throw new Exception('Arquivo de imagem não recebido');

        $uploadFile = $uploadListFiles[$position];

        $path = $uploadFile['tmp_name'];

        $file = explode('.', $uploadFile['name']);

        $object = new DImage();

        $object->path = Dir::getOnly($path);
        $object->extension = $object->normalizeExtension(array_pop($file));
        $object->name = implode('.', $file);

        switch ($object->extension) {
            case 'webp':
                $object->gd = imagecreatefromwebp($path);
                break;
            case 'jpe':
            case 'jpg':
            case 'jpeg':
                $object->gd = imagecreatefromjpeg($path);
                break;
            case 'bmp':
                $object->gd = imagecreatefrombmp($path);
                break;
            case 'png':
                $object->gd = imagecreatefrompng($path);
                imagealphablending($object->gd, true);
                imagesavealpha($object->gd, true);
                break;
            case 'gif':
                $object->gd = imagecreatefromgif($path);
                imagealphablending($object->gd, true);
                imagesavealpha($object->gd, true);
                break;
            default:
                throw new Error("Extenção de imagem [$object->extension] não suportada");
        }

        $object->size = [imagesx($object->gd), imagesy($object->gd)];


        if (in_array($object->extension, ['jpe', 'jpg', 'jpeg'])) {
            match (exif_read_data($path)['Orientation'] ?? 1) {
                2 => $object->flipH(),
                3 => $object->rotate(180, true),
                4 => $object->rotate(180, true)->flipH(),
                5 => $object->rotate(-90, true)->flipH(),
                6 => $object->rotate(-90, true),
                7 => $object->rotate(90, true)->flipH(),
                8 => $object->rotate(90, true),
                default => null
            };
        }

        return $object;
    }

    /** Cria um objeto DImage monocromatica */
    static function _color(int|array $size, string|array $color = 'fff'): DImage
    {
        $size = is_array($size) ? $size : [$size];

        $size[] = $size[0];

        if ($size[1] == 0) {
            $size[1] = $size[0];
        }
        if ($size[0] == 0) {
            $size[0] = $size[1];
        }

        $size = [array_shift($size), array_shift($size)];

        if ($size == [0, 0]) {
            $size[0] = [1, 1];
        }

        $object = new DImage();

        $object->size = $size;
        $object->name = 'autoColor-' . md5(uniqid());
        $object->color = $object->normalizeColor($color);
        $object->gd = imagecreatetruecolor(...$object->size);
        imagefill($object->gd, 0, 0, imagecolorallocate($object->gd, ...$object->color));

        return $object;
    }

    /** Cria um objeto DImage com base em um arquivo */
    static function _file(string $path): DImage
    {
        if (!File::check($path))
            throw new Error("Arquivo $path não encontrado");

        $path = path($path);
        $file = File::getOnly($path);
        $file = explode('.', $file);

        $object = new DImage();

        $object->path = Dir::getOnly($path);
        $object->extension = $object->normalizeExtension(array_pop($file));
        $object->name = implode('.', $file);

        switch ($object->extension) {
            case 'webp':
                $object->gd = imagecreatefromwebp($path);
                break;
            case 'jpe':
            case 'jpg':
            case 'jpeg':
                $object->gd = imagecreatefromjpeg($path);
                break;
            case 'bmp':
                $object->gd = imagecreatefrombmp($path);
                break;
            case 'png':
                $object->gd = imagecreatefrompng($path);
                imagealphablending($object->gd, true);
                imagesavealpha($object->gd, true);
                break;
            case 'gif':
                $object->gd = imagecreatefromgif($path);
                imagealphablending($object->gd, true);
                imagesavealpha($object->gd, true);
                break;
            default:
                throw new Error("Extenção de imagem [$object->extension] não suportada");
        }

        $object->size = [imagesx($object->gd), imagesy($object->gd)];

        if (in_array($object->extension, ['jpe', 'jpg', 'jpeg'])) {
            match (exif_read_data($path)['Orientation'] ?? 1) {
                2 => $object->flipH(),
                3 => $object->rotate(180, true),
                4 => $object->rotate(180, true)->flipH(),
                5 => $object->rotate(-90, true)->flipH(),
                6 => $object->rotate(-90, true),
                7 => $object->rotate(90, true)->flipH(),
                8 => $object->rotate(90, true),
                default => null
            };
        }

        return $object;
    }

    /** Cria um objeto DImage com base em uma URL de arquivo */
    static function _url(string $url): DImage
    {
        $object = new DImage();

        $tmpImage = file_get_contents($url);

        $object->name = 'url-' . md5($url);
        $object->gd = imagecreatefromstring($tmpImage);
        $object->size = [imagesx($object->gd), imagesy($object->gd)];

        return $object;
    }
}