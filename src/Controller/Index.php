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
        ob_start();
        include __DIR__.'/../../templates/index.php';
        $response = ob_get_clean();
        $this->response->setContent($response);
        
        return $this->response;
    }
}