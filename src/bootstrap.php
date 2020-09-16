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
    echo '<pre>';
    echo $e->getMessage();
}
catch (RouteNotFoundException $e)
{
    echo '<pre>';
    echo $e->getMessage();
}
catch (UnexpectedContentException $e)
{
    echo '<pre>';
    echo $e->getMessage();
}
catch (\Exception $e)
{
    echo '<pre>';
    echo $e->getMessage();
}