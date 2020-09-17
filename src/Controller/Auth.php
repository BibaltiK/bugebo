<?php

declare(strict_types=1);

namespace Exdrals\Bugebo\Controller;

use Exdrals\Excidia\Component\Http\Session;
use Exdrals\Bugebo\Controller\Account as AccountController;
use Exdrals\Bugebo\Entity\Account as AccountEntity;

class Auth {

    protected Session $session;    
    
    protected AccountController $accountController;


    public function __construct(Session $session, AccountController $accountController) 
    {
        $this->session = $session;
        $this->accountController = $accountController;
    }
    
    public function login(AccountEntity $loginAccount): bool
    {
        $toFindAccount = $this->accountController->findeByName($loginAccount->getName());
        if (!$toFindAccount)
        {            
            $this->session->addFlashMsg('Fehler bei Benutzer / Passwort kombination.');
            return false;
        }
        
        if (password_verify((string)$loginAccount->getPassword(), $toFindAccount->getPasswordHash()))
        {
            $this->session->set('useruuid', $toFindAccount->getUuid()); 
            $this->session->set('username', $toFindAccount->getName());
            return true;
        }        
        $this->session->addFlashMsg('Fehler bei Benutzer / Passwort kombination.');
        return false;
    }
    
    public function isLoggedin(): bool
    {
        return $this->session->get('useruuid') ? true : false;
    }
    
    public function logout() 
    {
        $this->session->unsetSession('useruuid');
        $this->session->unsetSession('username');
    }
}
