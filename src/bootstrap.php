<?php
declare(strict_types=1);
namespace Exdrals\Bugebo;
use Exdrals\Excidia\Component\Exception\{FileNotFoundException, 
                                         RouteNotFoundException,
                                         UnexpectedContentException
    };
use Exdrals\Excidia\Component\Dependency\Container;
use Symfony\Component\HttpFoundation\Request;
use Exdrals\Excidia\Component\Repository\DatabasePDO;
use Exdrals\Excidia\Component\Template\Template;
use Exdrals\Excidia\Component\Http\Session;

try
{       
    $dependency = new Container(__DIR__.'/../config/dependency.ini');
    $dependency->addObject('Exdrals\Excidia\Component\Dependency\Container', $dependency);
    
    $dependency->addObject('Exdrals\Excidia\Component\Repository\DatabasePDO', new DatabasePDO(__DIR__.'/../config/database.ini'));
    
    $session = $dependency->get('Exdrals\Excidia\Component\Http\Session');
        
    
    $request = (new Request())->createFromGlobals();            
    
    $request = $dependency->addObject('Symfony\Component\HttpFoundation\Request', clone $request);   
    
    if ((bool)mb_substr_count($request->getHttpHost(), 'local'))
    {
        define('DEVELOPE', 'true');        
    }

    $referer = $request->headers->get('referer');        
    if (!\is_string($referer) || !$referer || !(bool)mb_substr_count($referer, 'bugebo')) 
    {
        $session->set('redirect', '/');
    }    

    $router = $dependency->get('Exdrals\Excidia\Component\Router\Router');    
    $router->setRoutes(__DIR__.'/../config/routes.ini');
    $route = $router->match();
        
    $controller = $dependency->get($route['controller']);    
    $content = call_user_func_array(array($controller, $route['action']), []);
    
    $template = $dependency->get('Exdrals\Excidia\Component\Template\Template');    
    
    $auth = $dependency->get('Exdrals\Bugebo\Controller\Auth');    
    
}
catch (FileNotFoundException $e)
{
    if (!defined('DEVELOPE'))
    {
        header('Location: '.$session->get('redirect')); 
        exit();
    }
    echo '<pre>';
    echo $e->getMessage();    
    exit();
}
catch (RouteNotFoundException $e)
{
    if (!defined('DEVELOPE'))
    {
        header('Location: '.$session->get('redirect')); 
        exit();
    }
    echo '<pre>';
    echo $e->getMessage();
    exit();
}
catch (UnexpectedContentException $e)
{
    if (!defined('DEVELOPE'))
    {
        header('Location: '.$session->get('redirect')); 
        exit();
    }
    echo '<pre>';
    echo $e->getMessage();
    exit();
}
catch (\Exception $e)
{
    if (!defined('DEVELOPE'))
    {
        header('Location: '.$session->get('redirect')); 
        exit();
    }
    echo '<pre>';
    echo $e->getMessage();    
    exit();
}