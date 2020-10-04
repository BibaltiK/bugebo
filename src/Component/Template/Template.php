<?php
declare(strict_types=1);

namespace Exdrals\Excidia\Component\Template;
use Exdrals\Excidia\Component\Exception\FileNotFoundException;
use Psr\Container\ContainerInterface;

class Template {
    
    protected string $templatePath = __DIR__.'/../../../templates/';
    
    protected string $layout = 'default';

    protected string $templateExtension = '.phtml';
    
    protected ?array $data = [];

    public function __construct()
    {
        $this->data = [];
    }
    
    public function setTemplateFile(string $templateFile)
    {
        $this->templateFile = $templateFile;
    }
    
    public function insert(string $templateFile)
    {
        if (empty($templateFile))
        {
            return '';
        }
        return $this->render($templateFile);
    }
    
    public function assign(string $key, $value)
    {
        $this->data[$key] = $value;
    }
    
    public function getAssign(string $key): ?string
    {
        return $this->data[$key] ?? null;
    }

    public function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }

    public function render(string $templateFile = 'index')
    {
        $templateFile = $this->templatePath.'layout/'.$this->layout.'/'.$templateFile.$this->templateExtension;
        if (!is_readable($templateFile))
        {
            throw new FileNotFoundException(sprintf('Templatefile <b>%s</b> not found or readable!',$templateFile));
        }
        extract($this->data);
        ob_start();        
        include $templateFile;
        return ob_get_clean();
    }


    public function getTemplatePath(): string
    {
        return $this->templatePath;
    }

    public function setTemplatePath(string $templatePath): void
    {
        $this->templatePath = $templatePath;
    }

    public function getLayout(): string
    {
        return $this->layout;
    }

    public function setLayout(string $layout): void
    {
        $this->layout = $layout;
    }

    public function getTemplateExtension(): string
    {
        return $this->templateExtension;
    }

    public function setTemplateExtension(string $templateExtension): void
    {
        $this->templateExtension = $templateExtension;
    }
}
