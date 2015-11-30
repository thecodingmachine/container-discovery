# Containers discovery for *container-interop*

This package contains an interface and Puli binding-types to automatically discover containers.

## Introduction

*container-interop* defines a common interface for Container objects (the `ContainerInterface`).
This package proposes a default interface for factories that can generate container objects.
  
This factory is static and can be automatically detected by Puli using class discovery.

The goal is to allow a composite container to automatically detect and create container instances.

## Installation

```
composer require thecodingmachine/container-discovery@dev
```

This package adheres to the [SemVer](http://semver.org/) specification and will be fully backward compatible between minor versions.

## Containers discovery

The goal of this package is to enable a package to automatically publish or discover **containers**.

To automatically provide a *container* to your application, we use [Puli's discovery mechanism](http://docs.puli.io/en/latest/discovery/introduction.html).

This package contains a Puli **binding-type** named `container-interop/ContainerFactories`.
This binding-type should contain fully qualified class names implementing the `ContainerFactoryInterface` interface.

## Providing containers

To provide a container, write a `ContainerFactory` that will return an instance of your container implementing 
`ContainerInterface`.

For instance (using [Picotainer](https://github.com/mouf/picotainer)):

```php
namespace My\Package;

use Interop\Container\Factory\ContainerFactoryInterface;
use Assembly\ArrayDefinitionProvider;

class MyContainerFactory implements ContainerFactoryInterface {
    public static function buildContainer(ContainerInterface $rootContainer, Discovery $discovery) {
        return new Picotainer([
            'logger' => function() {
                new MyLogger();
            },
            $rootContainer
        ]);    
    }
}
```

Once your class is written, use Puli to bind it to the list of available containers:

```sh
$ puli bind "My\\Package\\MyContainerFactory" container-interop/ContainerFactories
```

Note: by convention, you can add a "priority" parameter to the binding. Default priority is 0. Lower priorities 
are processed first (and therefore, higher priorities are overloading lower priorities).

```sh
$ puli bind "My\\Package\\MyContainerFactory" container-interop/ContainerFactories --param priority=42
```


## Consuming containers

In your code, you can find all classes of the `container-interop/ContainerFactories` binding-type using:

```php
// $discovery is the Puli Discovery object.

$factories = $discovery->findByType('container-interop/ContainerFactories');

// TODO: sample code to sort by priority.
```
