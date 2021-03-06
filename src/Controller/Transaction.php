<?php

declare(strict_types=1);
namespace Exdrals\Bugebo\Controller;

use Exdrals\Bugebo\Component\Exception\RouteNotFoundException;
use Exdrals\Bugebo\Component\Template\Template;
use Exdrals\Bugebo\Component\Http\Session;
use Symfony\Component\HttpFoundation\Request;



class Transaction extends AbstractController
{
    public const PAYMENT_TYPE = ['incoming', 'outgoing'];
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

    public function newRearrangement()
    {

    }

    public function newPayment(string $paymentType): string
    {
        if (!in_array($paymentType,self::PAYMENT_TYPE))
        {
            throw new RouteNotFoundException(sprintf('No matching Parametes found for: <b>%s</b>',$paymentType));
        }
        $this->template->assign('konten', ['DKB', 'Deutsche-Bank']);
        $this->template->assign('paymentArts', ['Lastschrift', 'Überweisung', 'Kreditkarte', 'Barzahlung', 'EC-Karte', 'sonstiges']);
        $this->template->assign('paymentType', $paymentType);
        $this->template->assign('categories', ['Auto', 'Motor', 'Sport']);
        return $this->template->render('partials/transaction_payment_new');;
    }
}
