<?php

use Chewbathra\Chewby\Tests\TestCase;
use Illuminate\Support\Collection;

uses(TestCase::class)->in(__DIR__);
uses()->group('config')->in(__DIR__.'/Unit/ConfigTest.php');
uses()->group('chewby')->in(__DIR__.'/Unit/ChewbyTest.php');
 expect()->extend('toBeCollectionValues', function (Collection $collection) {
     return $this->toBe($collection->all());
 });
