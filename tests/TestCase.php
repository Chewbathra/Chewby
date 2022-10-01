<?php

namespace Chewbathra\Chewby\Tests;

use Chewbathra\Chewby\ChewbyServiceProvider;
use Chewbathra\Chewby\Config;
use Orchestra\Testbench\TestCase as Orchestra;
use Pest\Datasets;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
        /*
        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Chewbathra\\Chewby\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
        */
    }

    protected function getPackageProviders($app)
    {
        return [
            ChewbyServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');
        config()->set('chewby', Datasets::get('chewbyConfig'));
        // $object = new Config();
        // $reflection = new \ReflectionObject($object);
        // $property = $reflection->getProperty('controllersNamespace');
        // $property->setValue($object, 'Chewbathra\\Chewby\\Tests\\Datasets\\Controllers');
        // $object->controllersNamespace = "test";
        // $this->config = $object;

        /*
        $migration = include __DIR__.'/../database/migrations/create_skeleton_table.php.stub';
        $migration->up();
        */
    }
}
