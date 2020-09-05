<?php
declare(strict_types=1);

namespace Exdrals\Bugebo\Controller;
use Exdrals\Excidia\Component\Template\Template;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractController {
    
    protected Response $response;
    
    protected Template $template;
    
    public function __construct(Template $template, Response $response)
    {
        $this->response = $response;        
        $this->template = $template;
    }
}
