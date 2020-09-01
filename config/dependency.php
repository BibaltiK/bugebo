<?php
return [
    'Exdrals\Excidia\Component\Router\Router' => [
        'dependencies' => ['Symfony\Component\HttpFoundation\Request']
    ],
    'Exdrals\Bugebo\Controller\Index' => [
        'dependencies' => ['Symfony\Component\HttpFoundation\Response']
    ],
        'Exdrals\Bugebo\Controller\Account' => [
        'dependencies' => ['Symfony\Component\HttpFoundation\Response']
    ]
];