<?php
declare(strict_types=1);

namespace Exdrals\Bugebo\Template;


class Navigation {
      
    public function top() : ?string
    {                
        ob_start();
        $home = 'Startseite';
        include __DIR__.'/../../templates/layout/default/navigation_top.phtml';
        return ob_get_clean();
    }
    
}
