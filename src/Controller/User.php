<?php

declare(strict_types=1);

namespace Exdrals\Bugebo\Controller;
use Exdrals\Bugebo\Controller\AbstractController;
use Exdrals\Excidia\Component\Template\Template;
use Symfony\Component\HttpFoundation\Request;
use Exdrals\Bugebo\Controller\Auth;
use Exdrals\Bugebo\Entity\Account;
use Exdrals\Excidia\Component\Http\Session;

class User extends AbstractController
{       
    
    protected Auth $auth;
    protected Session $session;

    public function __construct(Template $template, Request $request, Auth $auth, Session $session) {
        $this->auth = $auth;
        $this->session = $session;
        
        parent::__construct($template, $request);
    }
    
    public function login(): ?string
    {        
        return 'Account-Login';
    }
    
    public function showLogin(): ?string
    {        
        if (!$this->auth->isLoggedin())
        {
            header('Location: '.$this->session->get('redirect'));        
        }
        
        return 'Account';
    }
    
    public function checkLogin()
    {        
        $user = new Account;
        $user->setName($this->request->request->get('username'));
        $user->setPassword($this->request->request->get('password'));
        $this->auth->login($user);
        header('Location: '.$this->session->get('redirect'));        
    }
    
    public function logout()
    {
        
        $this->auth->logout();
        header('Location: '.$this->session->get('redirect'));
    }
}
