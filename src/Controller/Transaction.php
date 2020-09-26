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
    
    public function newPayment(string $paymentType)
    {
        $this->template->assign('konten', ['DKB', 'Deutsche-Bank']);
        $this->template->assign('paymentArts', ['Lastschrift', 'Überweisung', 'Kreditkarte', 'Barzahlung', 'EC-Karte', 'sonstiges']);
        $this->template->assign('paymentType', $paymentType);
        $this->template->assign('categories', ['Auto', 'Motor', 'Sport']);
        return $this->template->render('partials/transaction_payment_new');;
    }
}
