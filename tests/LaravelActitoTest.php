<?php

namespace Cherrypulp\LaravelActito\Tests;

use Cherrypulp\LaravelActito\Facades\Actito;
use Cherrypulp\LaravelActito\ServiceProvider;
use Orchestra\Testbench\TestCase;

class LaravelActitoTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }

    protected function getPackageAliases($app)
    {
        return [
            'laravel-actito' => Actito::class,
        ];
    }

    public function testExample()
    {
        $this->assertEquals(1, 1);
    }
}
