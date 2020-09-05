<?php
declare(strict_types=1);

namespace Exdrals\Bugebo\Controller;

use Symfony\Component\HttpFoundation\Response;
use Exdrals\Bugebo\Controller\AbstractController;

class Index extends AbstractController
{
    
    public function index(): Response
    {                                       
        $this->response->setContent('$response');
        
        return $this->response;
    }
}