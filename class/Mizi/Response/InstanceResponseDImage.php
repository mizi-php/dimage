<?php

namespace Mizi\Response;

use Mizi\DImage;

class InstanceResponseDImage extends InstanceResponse
{
    function __construct(DImage $DImage = null, ?int $status = null)
    {
        parent::__construct($DImage, $status);
        $this->cache(true);
    }

    /** Define um objeto de imagem como conteúdo da resposta */
    function content(mixed $DImage): static
    {
        return parent::content($DImage);
    }

    /** Envia o conteúdo caso seja um objeto com o metodo send */
    protected function sendObject(?int $status): void
    {
    }

    /** Prepara o conteúdo da resposta */
    protected function prepareContent(): void
    {
        $DImage = $this->content;

        if (is_class($DImage, DImage::class)) {
            $this->downloadName = $this->downloadName ?? $DImage->getName();
            $this->contentType($DImage->getExtension());
            $this->content($DImage->getBin());
        } else {
            $this->content('invalid DImage');
            $this->status(STS_INTERNAL_SERVER_ERROR);
            $this->download(false);
        }
    }
}