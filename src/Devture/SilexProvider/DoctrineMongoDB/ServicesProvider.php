<?php
namespace Devture\SilexProvider\DoctrineMongoDB;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Doctrine\MongoDB\Connection;
use Doctrine\MongoDB\Configuration;
use Doctrine\Common\EventManager;

class ServicesProvider implements ServiceProviderInterface {

	public function __construct($namespace, array $config) {
		$defaultConfig = array(
			'server' => null,
			'options' => array(
				'connect' => false,
			),
		);
		$this->namespace = $namespace;
		$this->config = array_merge($defaultConfig, $config);
	}

	public function register(Application $app) {
		$namespace = $this->namespace;
		$config = $this->config;

		$app[$namespace . '.connection'] = $app->share(function ($app) use ($namespace, $config) {
			$configuration = $app[$namespace . '.configuration'];
			$eventManager = $app[$namespace . '.event_manager'];
			return new Connection($config['server'], $config['options'], $configuration, $eventManager);
		});

		$app[$namespace . '.configuration'] = $app->share(function () {
			return new Configuration();
		});

		$app[$namespace . '.event_manager'] = $app->share(function () {
			return new EventManager();
		});

	}

	public function boot(Application $app) {

	}

}
