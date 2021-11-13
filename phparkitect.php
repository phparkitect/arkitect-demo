<?php

declare(strict_types=1);

use Arkitect\ClassSet;
use Arkitect\CLI\Config;
use Arkitect\Expression\ForClasses\DependsOnlyOnTheseNamespaces;
use Arkitect\Expression\ForClasses\HaveNameMatching;
use Arkitect\Expression\ForClasses\NotHaveDependencyOutsideNamespace;
use Arkitect\Expression\ForClasses\ResideInOneOfTheseNamespaces;
use Arkitect\Rules\Rule;

return static function(Config $config): void
{
    $classSet = ClassSet::fromDir(__DIR__ . '/src');

    $r1 = Rule::allClasses()
        ->that(new ResideInOneOfTheseNamespaces('App\Catalog\Application\Service'))
        ->should(new HaveNameMatching('*Service'))
        ->because("we want uniform naming");

    $r2 = Rule::allClasses()
        ->that(new ResideInOneOfTheseNamespaces('App\Catalog\Domain'))
        ->should(new NotHaveDependencyOutsideNamespace('App\Catalog\Domain'))
        ->because('domain should not have external dependencies');

    $r3 = Rule::allClasses()
        ->that(new ResideInOneOfTheseNamespaces('App\Catalog\Application'))
        ->should(new DependsOnlyOnTheseNamespaces('App\Catalog\Domain'))
        ->because('we love exagonal architecture');

    $r4 = Rule::allClasses()
        ->that(new ResideInOneOfTheseNamespaces('App\Order\*'))
        ->should(new DependsOnlyOnTheseNamespaces('App\Order\*'))
        ->because('we want to preseve contexts');

    $config->add($classSet, $r1, $r2, $r3, $r4);
};