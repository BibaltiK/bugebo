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

use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

error_reporting(E_ALL);
ini_set ('display_errors', 'On');

require_once __DIR__ . '/../vendor/autoload.php';

 
try
{
    // Load routes from the yaml file
    $fileLocator = new FileLocator(array(__DIR__.'/../config'));
    $loader = new YamlFileLoader($fileLocator);
    $routes = $loader->load('routes.yaml');
 
    // Init RequestContext object
    $context = new RequestContext();
    $context->fromRequest(Request::createFromGlobals());
 
    // Init UrlMatcher object
    $matcher = new UrlMatcher($routes, $context);
 
    // Find the current route
    $parameters = $matcher->match($context->getPathInfo());
 
    // How to generate a SEO URL
    $generator = new UrlGenerator($routes, $context);
    $url = $generator->generate('foo_placeholder_route', array(
      'id' => 123,
    ));
 
    echo '<pre>';
    print_r($parameters);
 
    echo 'Generated URL: ' . $url;
    exit;
}
catch (ResourceNotFoundException $e)
{
  echo $e->getMessage();
}