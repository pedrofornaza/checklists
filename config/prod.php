<?php

// configure your app for the production environment

$app['doctrine.dbal'] = array(
    'db.options' => array(
        'driver' => 'pdo_mysql',
        'dbname' => 'checklist',
        'host' => '127.0.0.1',
        'user' => 'root',
        'password' => 'root',
        'charset' => 'utf8'
    )
);

$app['doctrine.orm'] = array(
    'orm.proxies_dir' => __DIR__.'/../var/cache/doctrine',
    'orm.em.options' => array(
        'mappings' => array(
            array(
                'type' => 'yml',
                'namespace' => 'Fornaza\Domain\Entities',
                'path' => __DIR__.'/doctrine',
            )
        ),
    )
);

$app['twig.path'] = array(__DIR__.'/../templates');
$app['twig.options'] = array('cache' => __DIR__.'/../var/cache/twig');

$app->register(new Silex\Provider\DoctrineServiceProvider(), $app['doctrine.dbal']);
$app->register(new Dflydev\Silex\Provider\DoctrineOrm\DoctrineOrmServiceProvider(), $app['doctrine.orm']);

$app['checklist.controller'] = $app->share(function() use ($app) {
    $repository = $app['orm.em']->getRepository('Fornaza\Domain\Entities\Checklist');
    return new Fornaza\Application\Controllers\Checklist($app, $repository, $app['twig']);
});

$app['step.controller'] = $app->share(function() use ($app) {
    $repository = $app['orm.em']->getRepository('Fornaza\Domain\Entities\Step');
    return new Fornaza\Application\Controllers\Step($app, $repository);
});
