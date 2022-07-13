# dimage

Tratamento de imagens com PHP GD

    composer require mizi/dimage

---
---

### Objetos de imagem

Existem 4 modos de se criar um objeto de imagem

> **NOTA**: A instancia de um objeto é feita de forma estatica

**upload**: Cria um objeto de imagem baseado em um arquivo no ([Request:file](https://github.com/mizi-php/server-back/tree/main/.doc/request.md))

    \Mizi\DImage::_upload(string $inputFileName, int $position = 0): DImage
    
**color**: Cria um objeto de imagem de cor unica

    \Mizi\DImage::_color(int|array $size, string|array $color = 'fff'): DImage

**file**: Cria um objeto de imagem baseado em um arquivo no servidor

    \Mizi\DImage::_file(string $path): DImage

**url**: Cria um objeto de imagem baseado em uma URL de imagem

    \Mizi\DImage::_url(string $url): DImage

---
### Alterar informações

**jpgQuality**: Define a qualidade da imagem para arquivos JPG
    
    $obj->jpgQuality(int $quality): self

---

**rename**: Define um nome para o arquivo
    
    $obj->rename(string $name): self

---

**name**: Define um nome para o arquivo
    
    $obj->name(string $name): self

---

**color**: Define a cor base da imagem
    
    $obj->color(string|array $color): self

---

### Manipulação

**convert**: Converte o arquivo de saida para outro formato
    
    $obj->convert(string $ex): self

---
**resize**: Redimenciona a imagem respeitando a proporção
    
    $obj->resize(int|array $size): self

O valor **$size** pode ter comportamentos diferentes

 - **int positivo**: dimensão maxima
 - **int negativo**: dimensão minima
 - **array[int,0]**: largura maxima
 - **array[0,int]**: altura maxima
 - **array[int,int]**: largura e altura maxima
     
---
**resizeFree**: Redimenciona a imagem não respeitando a proporção
    
    $obj->resizeFree(int|array $size): self

---

**rotate**: Rotaciona uma imagem.
    
    $obj->rotate(int $graus, bool $transparent = true): self

---

**flipH**: Inverte a imagem na horizontal
    
    $obj->flipH(): self

---

**flipV**: Inverte a imagem na vertical
    
    $obj->flipV(): self

---

**stamp**: Adiciona uma imagem dmx em uma posição da imagem atual
    
    $obj->stamp(DImage $imgSpamt, int $position = 0): self

O parametros **$position** pode ser um dos valores abaixo

 - **0**: centro
 - **1**: midle-left
 - **2**: top-left
 - **3**: top-center
 - **4**: top-right
 - **5**: midle-right
 - **6**: botom-right
 - **7**: botom-center
 - **8**: botom-left


---

**crop**: Corta uma parte do centro da imagem
    
    $obj->crop(int|array $size, int $position = 0): self

O parametros **$position** pode ser um dos valores abaixo

 - **0**: centro
 - **1**: midle-left
 - **2**: top-left
 - **3**: top-center
 - **4**: top-right
 - **5**: midle-right
 - **6**: botom-right
 - **7**: botom-center
 - **8**: botom-left

---

**framing**: Enquadra imagem
    
    $obj->framing(int|array $size): self

---

**filter**: Aplica um filtro GD a imagem
    
    $obj->filter(int $filter): self

---

### Recuperar de informações

**getName**: Retorna o nome da imagem
    
    $obj->getName(bool $ex = false): string

---

**getPath**: Retorna o caminho da imagem no disco
    
    $obj->getPath(): ?string

---

**getGd**: Retorna a imagem GD gerada pela classe
    
    $obj->getGd(): GdImage

---

**getSize**: Retorna o array de dimensão da imagem
    
    $obj->getSize(): array

---

**getWidth**: Retorna a largura da imagem
    
    $obj->getWidth(): int

---

**getHeight**: Retorna a altura da imagem
    
    $obj->getHeight(): int

---

**getExtension**: Retorna a extensao da imagem
    
    $obj->getExtension(): string

---

**getSizeFile**: Retorna o tamanho da imagem em MB
    
    $obj->getSizeFile(): float

---

**getHash**: Captura o Hash Md5 gerado pelo binario da imagem
    
    $obj->getHash(): string

---

**getBin**: Retorna o binario da imagem
    
    $obj->getBin(): string

---

### Utilização

---

**save**: Salva a imagem em um arquivo
    
    $obj->save(?string $path = null): self

---

**copy**: Retorna uma copia do objeto de imagem atua
    
    $obj->copy(): DImage


**send**: Envia a imagem como [resposta](https://github.com/mizi-php/server-back/tree/main/.doc/response.md) da requisição atual
    
    $obj->send($status): never


