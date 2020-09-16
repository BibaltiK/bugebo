<?php
declare(strict_types=1);

namespace Exdrals\Bugebo\Controller;
use Exdrals\Excidia\Component\Template\Template;
use Symfony\Component\HttpFoundation\Request;

abstract class AbstractController {
    
    protected Template $template;
    
    protected Request $request;


    public function __construct(Template $template, Request $request)
    {        
        $this->template = $template;        
        $this->request = $request;
    }
}
