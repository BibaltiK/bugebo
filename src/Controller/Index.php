<?php
declare(strict_types=1);

namespace Exdrals\Bugebo\Controller;

use Exdrals\Excidia\Component\Template\Template;
use Symfony\Component\HttpFoundation\Request;
use Exdrals\Bugebo\Controller\AbstractController;
use Exdrals\Bugebo\Controller\Auth;

class Index extends AbstractController
{
    
    protected Auth $auth;

    public function __construct(Template $template, Request $request, Auth $auth) 
    {
        $this->auth = $auth;
        parent::__construct($template, $request);
    }
    public function index() : ?string
    {                                                  
        return null;
    }
    
    public function addLoggedInBar()
    {
        if (!$this->auth->isLoggedin())
        {
            return null;
        }
        return $this->template->render('partials/navigation_loggedin_bar');
    }
}