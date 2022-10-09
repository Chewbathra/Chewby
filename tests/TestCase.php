<?php

namespace Chewbathra\Chewby\Tests;

use Chewbathra\Chewby\Facades\Config;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Facade;
use Orchestra\Testbench\TestCase as Orchestra;
use Pest\Datasets;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Chewbathra\\Chewby\\Tests\\Datasets\\Factory\\'.class_basename($modelName).'Factory'
        );

        Factory::guessModelNamesUsing(
            fn ($modelName) => 'Chewbathra\\Chewby\\Tests\\Datasets\\Models\\'.\Str::before(class_basename($modelName), 'Factory')
        );
    }

    protected function tearDown(): void
    {
        Facade::clearResolvedInstances();
    }

    protected function getPackageProviders($app)
    {
        return [
            ChewbyTestServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');
        config()->set('chewby', Datasets::get('config'));
        //Update controllers namespace in Config to reflect tests controllers
        $object = Config::getFacadeRoot();
        $reflection = new \ReflectionObject($object);
        $property = $reflection->getProperty('controllersNamespace');
        $property->setValue($object, 'Chewbathra\\Chewby\\Tests\\Datasets\\Controllers\\');

        $migration = include __DIR__.'/Datasets/Migrations/create_posts_table.php';
        $migration->up();

        $migration = include __DIR__.'/Datasets/Migrations/create_flights_table.php';
        $migration->up();
    }
}
