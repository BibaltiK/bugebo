<?php

declare(strict_types=1);

namespace Exdrals\Bugebo\Controller;

use Exdrals\Bugebo\Component\Http\Session;
use Exdrals\Bugebo\Component\Feature\FlashMessage;
use Exdrals\Bugebo\Repository\Account as AccountRepository;
use Exdrals\Bugebo\Entity\Account as AccountEntity;

class Auth {

    protected Session $session;    
    
    protected AccountRepository $accountRepository;
    
    protected FlashMessage $flashMessage;


    public function __construct(Session $session, AccountRepository $accountRepository, FlashMessage $flashMessage)
    {
        $this->session = $session;
        $this->accountRepository = $accountRepository;
        $this->flashMessage = $flashMessage;
    }
    
    public function login(AccountEntity $loginAccount): bool
    {
        $toFindAccount = $this->accountRepository->findByName($loginAccount->getName());
        if (!$toFindAccount)
        {            
            $this->flashMessage->add('Fehler bei Benutzer / Passwort kombination.', 'error');
            return false;
        }
        
        if (password_verify((string)$loginAccount->getPassword(), $toFindAccount->getPasswordHash()))
        {
            $this->session->set('useruuid', $toFindAccount->getUuid()); 
            $this->session->set('username', $toFindAccount->getName());
            return true;
        }        
        $this->flashMessage->add('Fehler bei Benutzer / Passwort kombination.', 'error');
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
