<?php
declare(strict_types=1);

namespace Exdrals\Bugebo\Controller;
use Exdrals\Bugebo\Controller\AbstractController;
use Exdrals\Excidia\Component\Template\Template;
use Symfony\Component\HttpFoundation\Request;
use Exdrals\Bugebo\Controller\Auth;

class Navigation extends AbstractController{
      
    protected Auth $auth;
    
    public function __construct(Template $template, Request $request, Auth $auth) {
        $this->auth =$auth;
        parent::__construct($template, $request);
    }


    public function top() : ?string
    {                                               
        return $this->template->render('partials/navigation_top');                
    }
    
    public function switchLoginStatus() : ?string
    {
        if (!$this->auth->isLoggedin())
        {            
            return $this->template->render('partials/navigation_top_loggedout');
        }
        return $this->template->render('partials/navigation_top_loggedin');
    }
    
}
