<?php
declare(strict_types=1);

use FootShop\web\WebApplication;
use Hafo\DI\Autowiring\AutowiringCache\NetteCache;
use Hafo\DI\Autowiring\DefaultAutowiring;
use Hafo\DI\ContainerBuilder;
use Nette\Caching\Cache;
use Nette\Caching\Storages\FileStorage;

require __DIR__ . '/../vendor/autoload.php';

$cacheStorage = new FileStorage(__DIR__ . '/../var/cache');
$cache = new Cache($cacheStorage, 'di.autowiring');

$containerBuilder = new ContainerBuilder();
$containerBuilder->setAutowiring(new DefaultAutowiring(new NetteCache($cache)));
$containerBuilder->addInterfaceImplementationMap(require_once __DIR__ . '/../config/implementations.php');
$containerBuilder->addParameters(require_once __DIR__ . '/../config/config.php');
$containerBuilder->addFactories(require_once __DIR__ . '/../config/services.php');

$container = $containerBuilder->createContainer();

$container->get(WebApplication::class)->run();
