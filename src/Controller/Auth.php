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
        $this->session->set('useruuid', 'ea49ab67-14e3-4a45-8691-4a6adcd79477');        
    }
    
    public function isLoggedin()
    {
        return $this->session->get('useruuid');
    }
    
    public function logout() 
    {
        $this->session->unsetSession('useruuid');
    }
}
