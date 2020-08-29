<?php
declare(strict_types=1);

namespace Exdrals\Bugebo\Controller;

use Symfony\Component\HttpFoundation\Response;

class Index
{
    protected Response $response;
    
    public function __construct(Response $response)
    {
        $this->response = $response;
    }
    
    public function index(): Response
    {
        $this->response->setContent("<p>Hallo Welt!</p>");
        
        return $this->response;
    }
}