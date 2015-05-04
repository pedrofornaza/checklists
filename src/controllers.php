<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

//Request::setTrustedProxies(array('127.0.0.1'));

$app->get('/', 'checklist.controller:listAction')->bind('checklists.list');

$app->get('/checklists/form', 'checklist.controller:formAction')->bind('checklists.form');
$app->post('/checklists/create', 'checklist.controller:createAction')->bind('checklists.create');

$app->get('/checklists/{id}/detail', 'checklist.controller:detailAction')->bind('checklists.detail');

$app->post('/checklists/{id}/complete', 'checklist.controller:completeAction')->bind('checklists.complete');

$app->post('/steps/{id}/complete', 'step.controller:completeAction')->bind('steps.complete');

$app->error(function (\Exception $e, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

    // 404.html, or 40x.html, or 4xx.html, or error.html
    $templates = array(
        'errors/'.$code.'.html',
        'errors/'.substr($code, 0, 2).'x.html',
        'errors/'.substr($code, 0, 1).'xx.html',
        'errors/default.html',
    );

    return new Response($app['twig']->resolveTemplate($templates)->render(array('code' => $code)), $code);
});
