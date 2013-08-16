<?php

use Sami\Sami;
use Symfony\Component\Finder\Finder;

return new Sami(
    Finder::create()
        ->files()
        ->name('*.php')
        ->in(__DIR__ . '/../../src/lib'),
    array(
        'title' => 'Example API',
        'build_dir' => __DIR__ . '/../../docs',
        'cache_dir' => __DIR__ . '/../cache/docs'
    )
);
