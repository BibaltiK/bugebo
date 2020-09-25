<?php
declare(strict_types=1);
namespace Exdrals\Bugebo;
use Symfony\Component\HttpFoundation\Request;
use Psr\Container\ContainerInterface;
use Exdrals\Excidia\Component\Exception\{   FileNotFoundException,
                                            RouteNotFoundException,
                                            UnexpectedContentException
};
use Exdrals\Excidia\Component\Dependency\Container;
use Exdrals\Bugebo\Controller\Auth;
use Exdrals\Excidia\Component\{ Router\Router,
                                Repository\DatabasePDO,
                                Template\Template,
                                Http\Session
};
use Ramsey\Uuid\Uuid;

try
{
    error_reporting(-1);
    ini_set ('display_errors', 'On');
    $dependency = new Container(require_once __DIR__.'/../config/dependencies.php');
    $dependency->set(DatabasePDO::class, new DatabasePDO(__DIR__.'/../config/database.ini'));
    $dependency->set(Request::class, (new Request())->createFromGlobals());

    $session = $dependency->get(Session::class);
    $request = $dependency->get(Request::class);

    define('PROJECT_BASE', $request->getHttpHost());
    if ((bool)mb_substr_count($request->getHttpHost(), 'local'))
    {
        define('DEVELOPE', 'true');
    }

    error_reporting(0);

    if (defined('DEVELOPE'))
    {
        error_reporting(-1);
        ini_set ('display_errors', 'On');
    }
    $referer = $request->headers->get('referer');
    if (!\is_string($referer) || !$referer || !(bool)mb_substr_count($referer, 'bugebo'))
    {
        $session->set('redirect', '/');
    }

    $router = $dependency->get(Router::class);
    $router->setRoutes(__DIR__.'/../config/routes.ini');
    $route = $router->match();

    $template = $dependency->get(Template::class);
    $auth = $dependency->get(Auth::class);

    $controller = $dependency->get($route['controller']);
    $content = call_user_func_array(array($controller, $route['action']), []);
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