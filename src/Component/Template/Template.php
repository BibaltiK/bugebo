<?php

declare(strict_types=1);

namespace Exdrals\Excidia\Component\Template;

use Exdrals\Excidia\Component\Exception\FileNotFoundException;

use function extract;
use function htmlspecialchars;
use function is_readable;
use function ob_get_clean;
use function ob_start;
use function sprintf;

class Template
{
    protected string $path = '';
    protected string $layout = 'default';
    protected string $extension = '.phtml';
    protected array $data = [];

    public function assign(string $key, mixed $value): void
    {
        $this->data[$key] = $value;
    }

    public function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES);
    }

    public function render(string $templateFile = 'index'): string
    {
        if(empty($templateFile)) {
            return '';
        }
        $templateFile = $this->path . 'layout/' . $this->layout . '/' . $templateFile . $this->extension;
        if(!is_readable($templateFile)) {
            throw new FileNotFoundException(sprintf('Templatefile <b>%s</b> not found or readable!', $templateFile));
        }
        extract($this->data);
        ob_start();
        include $templateFile;
        return ob_get_clean();
    }

    public function setPath(string $path): void
    {
        $this->path = $path;
    }
}
