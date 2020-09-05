<?php

declare(strict_types=1);

namespace Exdrals\Bugebo\Controller;
use Symfony\Component\HttpFoundation\Response;
use Exdrals\Bugebo\Controller\AbstractController;

class Account extends AbstractController
{
    public function login(): Response
    {
        $this->template->setIndexFile('error');
        $this->response->setContent('Account-Login');
        return $this->response;
    }
    
    public function show(): Response
    {
        $this->response->setContent('Account');
        return $this->response;
    }
}
