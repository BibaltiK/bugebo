<?php
declare(strict_types=1);

namespace Exdrals\Bugebo\Template;


class Index {
    
    public function index() : ?string
    {        
        ob_start();
        include __DIR__.'/../../templates/index.phtml';
        return ob_get_clean();
    }
    
}
