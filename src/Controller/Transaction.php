<?php

declare(strict_types=1);
namespace Exdrals\Bugebo\Controller;

use Exdrals\Excidia\Component\Template\Template;
use Exdrals\Excidia\Component\Http\Session;
use Symfony\Component\HttpFoundation\Request;
use Exdrals\Bugebo\Controller\AbstractController;
use Exdrals\Bugebo\Controller\Auth;


class Transaction extends AbstractController
{
    
    protected Auth $auth;
    protected Session $session;

    public function __construct(Template $template, Request $request, Auth $auth, Session $session) 
    {
        $this->auth = $auth;   
        $this->session = $session;
        parent::__construct($template, $request);
        if (!$this->auth->isLoggedin())
        {
            header('Location: '.$this->session->get('redirect'));        
            exit();
        }
    }
    
    public function newIncomingPayment()
    {
        return $this->template->render('partials/transaction_payment_new');;
    }
}