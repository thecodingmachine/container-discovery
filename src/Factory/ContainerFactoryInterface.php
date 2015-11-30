<?php

namespace Interop\Container\Factory;

use Interop\Container\ContainerInterface;
use Puli\Discovery\Api\Discovery;

/**
 * Classes implementing this interface are factories that can be used to create containers.
 */
interface ContainerFactoryInterface
{
    /**
     * Creates a container.
     *
     * @param ContainerInterface $rootContainer
     * @param Discovery $discovery
     *
     * @return ContainerInterface
     */
    public static function buildContainer(ContainerInterface $rootContainer, Discovery $discovery);
}
