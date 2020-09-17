<?php

declare(strict_types=1);

namespace Exdrals\Bugebo\Controller;
use Exdrals\Bugebo\Controller\AbstractController;
use Exdrals\Excidia\Component\Template\Template;
use Symfony\Component\HttpFoundation\Request;
use Exdrals\Bugebo\Controller\Auth;
use Exdrals\Bugebo\Entity\Account;
use Exdrals\Excidia\Component\Http\Session;
use Exdrals\Excidia\Component\Feature\FlashMessage;

class User extends AbstractController
{       
    
    protected Auth $auth;
    protected Session $session;
    protected FlashMessage $flashMessage;

    public function __construct(Template $template, Request $request, Auth $auth, Session $session, FlashMessage $flashMessage) 
    {
        $this->auth = $auth;
        $this->session = $session;
        $this->flashMessage = $flashMessage;
        
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
        $username = $this->request->request->get('username');
        $password = $this->request->request->get('password');
        if ((!isset($username) || empty($username)) || (!isset($password) || empty($password)))
        {
            $this->flashMessage->add('Benutzername / Passwort müssen ausgefüllt werden', 'error');            
            
            header('Location: '.$this->session->get('redirect'));        
            exit();
        }
        $user->setName($username);
        $user->setPassword($password);
        if ($this->auth->login($user))
        {
            $this->flashMessage->add('Anmeldung erfolgreich.', 'success');            
        }
        header('Location: '.$this->session->get('redirect')); 
        exit();
    }
    
    public function logout()
    {
        
        $this->auth->logout();
        header('Location: '.$this->session->get('redirect'));
    }
}
