<?php
declare(strict_types=1);

namespace Exdrals\Bugebo\Controller;

use Exdrals\Bugebo\Controller\AbstractController;

class Index extends AbstractController
{
    
    public function index() : ?string
    {                                                  
        return 'Index';
    }
}