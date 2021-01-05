<?php
declare(strict_types=1);
namespace Exdrals\Bugebo;
use Exdrals\Bugebo\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Exdrals\Bugebo\Component\Exception\{   FileNotFoundException,
                                            RouteNotFoundException,
                                            UnexpectedContentException,
                                            NotFoundException
};
use Exdrals\Bugebo\Component\Dependency\Container;
use Exdrals\Bugebo\Controller\Auth;
use Exdrals\Bugebo\Component\{ Router\Router,
                                Repository\DatabasePDO,
                                Template\Template,
                                Http\Session,
                                Feature\FlashMessage
};
use Ramsey\Uuid\Uuid;

try
{
    error_reporting(-1);
    ini_set ('display_errors', 'On');
    $dependency = new Container(require_once __DIR__.'/../config/dependencies.php');
    $dependency->set(DatabasePDO::class, new DatabasePDO(require_once __DIR__.'/../config/database.php'));
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
    $router->setRoutes(require_once __DIR__.'/../config/routes.php');
    $route = $router->match();

    $template = $dependency->get(Template::class);
    $template->setPath(__DIR__ . '/../templates/layout/default');

    $auth = $dependency->get(Auth::class);

    $flashMessage = $dependency->get(FlashMessage::class);

    $controller = $dependency->get($route['controller']);

    $content = call_user_func_array(array($controller, $route['action']), $route['params'] ?? []);
}
catch (FileNotFoundException | RouteNotFoundException | \Exception | UnexpectedContentException | NotFoundException $e)
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
