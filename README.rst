Silex Doctrine-MongoDB Provider
===============================

A Doctrine-MongoDB provider for the `Silex <http://silex.sensiolabs.org/>`_ micro-framework.

Usage
-----

Registering the provider creates a few services under a given *namespace*.
The provider can be registered multiple times if multiple connections are needed.

Basic Usage::

	<?php
	//Register services under the 'mongodb' namespace, with no custom configuration (empty array)
	$app->register(new \Devture\SilexProvider\DoctrineMongoDB\ServicesProvider('mongodb', array()));

	//Get a reference to a database on that server connection
	$app['db'] = $app->share(function ($app) {
		return $app['mongodb.connection']->selectDatabase('database_name');
	});

Advanced Usage::

	<?php
	//See the docs for \MongoClient (http://php.net/MongoClient) for connection string format and options
	$configuration = array(
		'server' => 'mongodb://example.com:27017',
		'options' => array(
			'connect' => true,
			'connectTimeoutMS' => 200,
		),
	);

	$app->register(new \Devture\SilexProvider\DoctrineMongoDB\ServicesProvider('mongodb', $configuration));

	$app['db_main'] = $app->share(function ($app) {
		return $app['mongodb.connection']->selectDatabase('database_name');
	});

	$app['db_other'] = $app->share(function ($app) {
		return $app['mongodb.connection']->selectDatabase('another_database_name');
	});
