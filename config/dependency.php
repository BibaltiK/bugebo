<?php
return [
    
    'Exdrals\Excidia\Component\Router\Router' => [
        'dependencies' => ['Symfony\Component\HttpFoundation\Request']
    ],    
    'Exdrals\Bugebo\Controller\Auth' => [
        'dependencies' => ['Exdrals\Excidia\Component\Http\Session']
    ],    
    'Exdrals\Excidia\Component\Template\Template' => [
        'dependencies' => ['Exdrals\Excidia\Component\Dependency\Container']
    ],
    'Exdrals\Bugebo\Controller\Navigation' => [
        'dependencies' => ['Exdrals\Excidia\Component\Template\Template', 'Exdrals\Bugebo\Controller\Auth']
    ],
    'Exdrals\Bugebo\Controller\Index' => [
        'dependencies' => ['Exdrals\Excidia\Component\Template\Template']
    ],
    'Exdrals\Bugebo\Controller\Account' => [
        'dependencies' => ['Exdrals\Excidia\Component\Template\Template', 'Exdrals\Bugebo\Controller\Auth']
    ]
];