<?php
return [
    
    'Exdrals\Excidia\Component\Router\Router' => [
        'dependencies' => ['Symfony\Component\HttpFoundation\Request']
    ],
    'Exdrals\Bugebo\Controller\PageController' => [
        'dependencies' => ['Exdrals\Excidia\Component\Template\Template','Symfony\Component\HttpFoundation\Response']
    ],
    'Exdrals\Bugebo\Controller\Index' => [
        'dependencies' => ['Exdrals\Excidia\Component\Template\Template','Symfony\Component\HttpFoundation\Response']
    ],
    'Exdrals\Bugebo\Controller\Account' => [
        'dependencies' => ['Exdrals\Excidia\Component\Template\Template','Symfony\Component\HttpFoundation\Response']
    ]
];