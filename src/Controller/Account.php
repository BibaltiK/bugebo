<?php

declare(strict_types=1);

namespace Exdrals\Bugebo\Controller;
use Symfony\Component\HttpFoundation\Response;

class Account 
{
    protected Response $response;
    
    public function __construct(Response $response)
    {
        $this->response = $response;
    }
    
    public function login()
    {
        $this->response->setContent('Account-Login');
        return $this->response;
    }
    
    public function show()
    {
        $this->response->setContent('Account');
        return $this->response;
    }
}
