<?php

declare(strict_types=1);

namespace Exdrals\Bugebo\Controller;
use Exdrals\Bugebo\Controller\AbstractController;
use Exdrals\Excidia\Component\Template\Template;
use Exdrals\Bugebo\Controller\Auth;

class Account extends AbstractController
{       
    
    protected Auth $auth;
    
    public function __construct(Template $template, Auth $auth) {
        $this->auth =$auth;
        parent::__construct($template);
    }
    
    public function login(): ?string
    {        
        return 'Account-Login';
    }
    
    public function showLogin(): ?string
    {        
        return 'Account';
    }
    
    public function checkLogin(): ?string
    {        
        $this->auth->login();
        header('Location: /');
        return 'Du wollen Log-In?<br> Welcome!';
    }
    
    public function logout()
    {
        $this->auth->logout();
        header('Location: /');
        return 'bye bye';
    }
}
