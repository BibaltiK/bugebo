<?php

declare(strict_types=1);

namespace Exdrals\Bugebo\Component\Template;

use Exdrals\Bugebo\Component\Exception\FileNotFoundException;

use function extract;
use function htmlspecialchars;
use function is_readable;
use function ob_get_clean;
use function ob_start;
use function sprintf;

class Template
{
    protected string $path = '';
    protected array $data = [];

    public function assign(string $key, mixed $value): void
    {
        $this->data[$key] = $value;
    }

    public function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES);
    }

    public function render(string $fileName = 'index'): string
    {
        if(empty($fileName)) {
            return '';
        }
        $fileName = $this->path .  $fileName . '.phtml';
        if(!is_readable($fileName)) {
            throw new FileNotFoundException(
                sprintf('Templatefile <b>%s</b> not found or readable!', $fileName)
            );
        }
        extract($this->data);
        ob_start();
        include $fileName;
        return ob_get_clean();
    }

    public function setPath(string $path): void
    {
        $this->path = rtrim($path, '/') . '/';
    }
}
