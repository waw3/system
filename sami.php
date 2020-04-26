<?

// php sami.phar update sami.php
//  php sami.phar render sami.php

use Sami\Sami;
use Sami\RemoteRepository\GitHubRemoteRepository;
use Sami\Version\GitVersionCollection;
use Symfony\Component\Finder\Finder;

$dir = __DIR__ . '/Modules';

$iterator = Finder::create()
    ->files()
    ->name("*.php")
    ->exclude('build')
    ->exclude("node_modules")
    ->exclude("resources")
    ->exclude("database")
    ->exclude("config")
    ->exclude("routes")
    ->exclude("bootstrap")
    ->exclude("storage")
    ->exclude("vendor")
    ->exclude('tests')
    ->in(__DIR__ ."/app")
    ->in(__DIR__ ."/Modules");


$sami = new Sami($iterator, [
    'theme'                => 'default',
    'title'                => 'Laravel API Documentation',
    'build_dir'            => __DIR__ . '/build/laravel',
    'cache_dir'            => __DIR__ . '/cache/laravel',
    'template_dirs'        => array(__DIR__ . '/packages/sami/src/Resources/themes/default'),
]);


return $sami;
