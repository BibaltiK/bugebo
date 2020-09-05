<?php

declare(strict_types=1);

namespace Exdrals\Bugebo\Controller;
use Symfony\Component\HttpFoundation\Response;
use Exdrals\Bugebo\Controller\AbstractController;

class PageController extends AbstractController
{
    
    protected string $siteTitle = 'Bugebo';


    public function process()
    {
        $this->template->assign('site_title', $this->siteTitle);
        $this->setTopNavigation();
    }
    
    public function setSiteTitle(string $siteTitle)
    {
        $this->siteTitle=$siteTitle;
        $this->template->assign('site_title', $this->siteTitle);
    }
    
    protected function setTopNavigation()
    {
        $this->template->add('Navigation','top', 'navigation_top');        
        
    }
}
