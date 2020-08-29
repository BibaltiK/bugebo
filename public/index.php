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

use Exdrals\Excidia\Component\Router\Router;
use Exdrals\Excidia\Component\Exception\{FileNotFoundException, 
                                         RouteNotFoundException,
                                         UnexpectedContentException
    };
use Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\HttpFoundation\Response;

error_reporting(E_ALL);
ini_set ('display_errors', 'On');

require_once __DIR__ . '/../vendor/autoload.php';

try
{    
    $request = (new Request())->createFromGlobals();
    $router = new Router($request);
    $router->setRoutes(__DIR__.'/../config/routes.php');
    $route = $router->match();
    
    echo '<pre>';
    print_r($route);
}
catch (FileNotFoundException $e)
{
    echo $e->getMessage();
}
catch (RouteNotFoundException $e)
{
    echo $e->getMessage();
}
catch (UnexpectedContentException $e)
{
    echo $e->getMessage();
}
catch (\Exception $e)
{
    echo $e->getMessage();
}