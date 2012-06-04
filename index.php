<?php
require_once __DIR__.'/silex.phar';
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app = new Silex\Application();

// Use Twig
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path'       => __DIR__.'/views',
    'twig.class_path' => __DIR__.'/vendor/twig/lib',
));

// Use Doctrine DBAL
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options'	=> array(
        'driver'	=> 'pdo_sqlite',
        'path' 		=> __DIR__.'/app.db',
    ),
    'db.dbal.class_path'    => __DIR__.'/vendor/doctrine-dbal/lib',
    'db.common.class_path'  => __DIR__.'/vendor/doctrine-common/lib',
));

// Debug Mode
$app['debug'] = true;

// top
$app->get('/', function () use ($app) {

	$sql = "select id, text from article limit 50";
	$article = $app['db']->fetchAll($sql);

	// 件数取得
	$sql = "select count(*) from article";
	$count = $app['db']->fetchAssoc($sql);

	return $app['twig']->render('table.twig', array(
		"article" => $article
	));

});

// create
$app->post('/create', function (Request $request) use ($app) {

	$id = $request->get('id');
	$text = $request->get('text');
	
	$app['db']->insert('article', array(
		'id' => $id,
		'text' => $text,
		'created' => ''
	));

	// Redirect TopPage
	return $app->redirect('/');

});

// create
$app->post('/create/json', function (Request $request) use ($app) {

	$id = $request->get('id');
	$text = $request->get('text');
	
	$app['db']->insert('article', array(
		'id' => $id,
		'text' => $text,
		'created' => ''
	));

	return new Response(
		json_encode(array('status' => 'successful')),
		200,
		array('Content-Type' => 'application/json')
	);
});


// delete
$app->post('/delete', function (Request $request) use ($app) {

	$id = $request->get('id');

	$app['db']->delete('article', array('id' => $id));

	// Redirect TopPage
	return $app->redirect('/');

});

// delete ajax
$app->post('/delete/json', function (Request $request) use ($app) {

	$id = $request->get('id');

	$app['db']->delete('article', array('id' => $id));

	return new Response(
		json_encode(array('status' => 'successful')),
		200,
		array('Content-Type' => 'application/json')
	);
});

// update
$app->post('/update', function (Request $request) use ($app) {

	$id = $request->get('id');
	$text = $request->get('text');

	$app['db']->update('article', array('text' => $text), array('id' => $id));

	// Redirect TopPage
	return $app->redirect('/');

});
// update ajax
$app->post('/update/json', function (Request $request) use ($app) {

	$id = $request->get('id');
	$text = $request->get('text');

	$app['db']->update('article', array('text' => $text), array('id' => $id));

	// Redirect TopPage
	return new Response(
		json_encode(array('success' => 'true')),
		200,
		array('Content-Type' => 'application/json')
	);

});


$app->run();

