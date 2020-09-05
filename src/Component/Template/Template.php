<?php
declare(strict_types=1);

namespace Exdrals\Excidia\Component\Template;


class Template {
    
    protected string $templatePath = __DIR__.'/../../../templates/';
    
    protected string $layout = 'default';
    
    protected string $indexFile = 'index';
    
    protected string $templateExtension = '.phtml';
    
    protected string $templateNamespace = 'Exdrals\Bugebo\Template\\';


    protected ?array $data = [];
            
    public function __construct() 
    {
        $this->data = [];
    }
    
    public function setIndexFile(string $indexFile)
    {
        $this->indexFile = $indexFile;
    }

    public function add(string $class, string $method = 'process', string $section = 'index')
    {        
        $class = $this->templateNamespace.$class;
        $object = new $class;
        $this->data[$section] = call_user_func_array(array($object, $method), []);                
    }
    
    public function assign(string $key, $value)
    {
        $this->data[$key] = $value;
    }


    public function render()
    {
        extract($this->data);
        ob_start();
        include $this->templatePath.'layout/'.$this->layout.'/'.$this->indexFile.$this->templateExtension;
        return ob_get_clean();
    }
}
