# Silex Doctrine-MongoDB Provider

A [doctrine/mongodb](https://github.com/doctrine/mongodb) provider for the [Silex](https://github.com/silexphp/Silex) micro-framework.

## Usage

Registering the provider creates a few services under a given *namespace*.
The provider can be registered multiple times if multiple connections are needed.

### Basic Usage

```php
<?php
// Register services under the 'mongodb' namespace, with no custom configuration (empty array)
$app->register(new \Devture\SilexProvider\DoctrineMongoDB\ServicesProvider('mongodb', []));

// Get a reference to a database on that server connection
$app['db'] = function ($app) {
	return $app['mongodb.connection']->selectDatabase('database_name');
};
```

### Advanced Usage

```php
<?php
// See the docs for \MongoClient (http://php.net/MongoClient) for connection string format and options
$configuration = [
	'server' => 'mongodb://example.com:27017',
	'options' => [
		'connect' => true,
		'connectTimeoutMS' => 200,
	],
];

$app->register(new \Devture\SilexProvider\DoctrineMongoDB\ServicesProvider('mongodb', $configuration));

$app['db_main'] = function ($app) {
	return $app['mongodb.connection']->selectDatabase('database_name');
};

$app['db_other'] = function ($app) {
	return $app['mongodb.connection']->selectDatabase('another_database_name');
};
```
