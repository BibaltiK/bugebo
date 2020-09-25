<?php
declare(strict_types=1);

namespace Exdrals\Excidia\Component\Template;
use Exdrals\Excidia\Component\Exception\FileNotFoundException;
use Psr\Container\ContainerInterface;

class Template {
    
    protected string $templatePath = __DIR__.'/../../../templates/';
    
    protected string $layout = 'default';
    
    protected string $templateFile = 'index';
    
    protected string $templateExtension = '.phtml';
    
    protected string $templateNamespace = 'Exdrals\Bugebo\Controller';

    protected ?array $data = [];
    
    protected ContainerInterface $dependency;

    
    public function __construct(ContainerInterface $dependency)
    {
        $this->data = [];
        $this->dependency = $dependency;
    }
    
    public function setTemplateFile(string $templateFile)
    {
        $this->templateFile = $templateFile;
    }

    public function add(string $class, string $method = 'process')
    {        
        $class = $this->templateNamespace.'\\'.$class;        
        $object = $this->dependency->get($class);
        return call_user_func_array(array($object, $method), []);                
    }
    
    public function insert(string $templateFile)
    {
        return $this->render($templateFile);
    }
    
    public function assign(string $key, $value)
    {
        $this->data[$key] = $value;
    }
    
    public function getAssign(string $key)
    {
        return $this->data[$key] ?? false;
    }

    public function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }

    public function render(?string $templateFile = null)
    {
        $templateFile = $templateFile ?? $this->templateFile;
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
}
