<?php

declare(strict_types=1);

namespace Exdrals\Bugebo\Controller;

use Exdrals\Excidia\Component\Http\Session;

class Auth {

    protected Session $session;
    
    public function __construct(Session $session) 
    {
        $this->session = $session;
    }
    
    public function login() 
    {
        $this->session->set('login', true);
    }
    
    public function isLoggin()
    {
        return $this->session->get('login');
    }
    
    public function logout() 
    {
        $this->session->unsetSession('login');
    }
}
