<?php
/**
 *
 * MIT License
 *
 * Copyright (c) 2014-2020 BibaltiK - eXdraLs.de
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 * @package     Exdrals\Bugebo
 * @version     0.1-dev
 * @author      BibaltiK
 * @see         https://github.com/BibaltiK/bugebo
 * @copyright   2020 exdrals.de
 * @link        http://bugebo.exdrals.de
 * @license     MIT License <https://opensource.org/licenses/MIT>
 */
declare(strict_types=1);

namespace Exdrals\Bugebo;

use Exdrals\Excidia\Component\Exception\{FileNotFoundException, 
                                         RouteNotFoundException,
                                         UnexpectedContentException
    };
use Exdrals\Excidia\Component\Dependency\Container;
use Symfony\Component\HttpFoundation\Request;
use Exdrals\Excidia\Component\Template\Template;
use Exdrals\Excidia\Component\Http\Session;

error_reporting(-1);
ini_set ('display_errors', 'On');

require_once __DIR__ . '/../vendor/autoload.php';

try
{   
    $dependency = new Container(__DIR__.'/../config/dependency.ini');
    $dependency->addObject('Exdrals\Excidia\Component\Dependency\Container', $dependency);
    
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

    $template->assign('siteTitle', 'Bugebo');
    $template->assign('username', 'Gast');
    if ($auth->isLoggedin())
    {
        $template->assign('username', 'BibaltiK');
    }
    
    $template->assign('home', 'Startseite');    
    $template->assign('content', $content); 
    

    
    echo $template->render();  
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