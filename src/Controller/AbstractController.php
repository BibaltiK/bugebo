<?php
declare(strict_types=1);

namespace Exdrals\Bugebo\Controller;
use Exdrals\Excidia\Component\Template\Template;

abstract class AbstractController {
    
    protected Template $template;
    
    public function __construct(Template $template)
    {        
        $this->template = $template;        
    }
}
