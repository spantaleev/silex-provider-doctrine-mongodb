<?php
namespace Devture\SilexProvider\DoctrineMongoDB;

use Doctrine\MongoDB\Connection;
use Doctrine\MongoDB\Configuration;
use Doctrine\Common\EventManager;

class ServicesProvider implements \Pimple\ServiceProviderInterface, \Silex\Api\BootableProviderInterface {

	public function __construct(string $namespace, array $config) {
		$defaultConfig = [
			'server' => null,
			'options' => [
				'connect' => false,
			],
		];
		$this->namespace = $namespace;
		$this->config = array_merge($defaultConfig, $config);
	}

	public function register(\Pimple\Container $container) {
		$namespace = $this->namespace;
		$config = $this->config;

		$container[$namespace . '.connection'] = function ($container) use ($namespace, $config) {
			$configuration = $container[$namespace . '.configuration'];
			$eventManager = $container[$namespace . '.event_manager'];
			return new Connection($config['server'], $config['options'], $configuration, $eventManager);
		};

		$container[$namespace . '.configuration'] = function () {
			return new Configuration();
		};

		$container[$namespace . '.event_manager'] = function () {
			return new EventManager();
		};

	}

	public function boot(\Silex\Application $container) {

	}

}
