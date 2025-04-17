<?php

/**
 * Copyright (c) D3 Data Development (Inh. Thomas Dartsch)
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * https://www.d3data.de
 *
 * @copyright (C) D3 Data Development (Inh. Thomas Dartsch)
 * @author    D3 Data Development - Daniel Seifert <info@shopmodule.com>
 * @link      https://www.oxidmodule.com
 */

declare(strict_types=1);

namespace D3\TestingTools\Development;

use OxidEsales\EshopCommunity\Internal\Container\ContainerBuilderFactory;
use OxidEsales\EshopCommunity\Internal\Container\ContainerFactory;
use PHPUnit\Framework\MockObject\MockObject;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;

trait CanAccessRestricted
{
    /**
     * Calls a public, private or protected object method.
     *
     * @param object $object
     * @param string $methodName
     * @param array  $arguments
     *
     * @return mixed
     * @throws ReflectionException
     */
    public function callMethod(object $object, string $methodName, array $arguments = []): mixed
    {
        $class  = new ReflectionClass($object);
        $method = $class->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $arguments);
    }

    /**
     * Sets a public, private or protected property in class instance
     *
     * @param object $object
     * @param string $valueName
     * @param mixed $value
     * @throws ReflectionException
     */
    public function setValue(object $object, string $valueName, mixed $value): void
    {
        $reflection = new ReflectionClass($object);
        $property = $reflection->getProperty($valueName);
        $property->setAccessible(true);
        $property->setValue($object, $value);
    }

    /**
     * get a public, private or protected property from class instance
     *
     * @param object $object
     * @param string $valueName
     * @return mixed
     * @throws ReflectionException
     */
    public function getValue(object $object, string $valueName): mixed
    {
        $reflection = new ReflectionClass($object);
        $property = $reflection->getProperty($valueName);
        $property->setAccessible(true);
        return $property->getValue($object);
    }

    /**
     * Sets a public, private or protected property in mocked class instance based on original class
     * (required for e.g. final properties, which aren't contained in mock, but in original class)
     * @param string $mockedClassName  * FQNS of original class
     * @param MockObject $object       * mock object
     * @param string $valueName        * property name
     * @param mixed $value             * new property value
     *
     * @throws ReflectionException
     */
    public function setMockedClassValue(string $mockedClassName, MockObject $object, string $valueName, mixed $value): void
    {
        $property = new ReflectionProperty($mockedClassName, $valueName);
        $property->setAccessible(true);
        $property->setValue($object, $value);
    }

    /**
     * get a private or protected property from mocked class instance based on original class
     * (required for e.g. final properties, which aren't contained in mock, but in original class)
     *
     * @param string $mockedClassName
     * @param MockObject $object
     * @param string $valueName
     *
     * @return mixed
     * @throws ReflectionException
     */
    public function getMockedClassValue(string $mockedClassName, MockObject $object, string $valueName): mixed
    {
        $property = new ReflectionProperty($mockedClassName, $valueName);
        $property->setAccessible(true);
        return $property->getValue($object);
    }

    /**
     * use \OxidEsales\EshopCommunity\Internal\Container\ContainerFactory::resetContainer() to undo these modifications
     * @param array<string, object> $services
     * @return void
     * @throws ReflectionException
     */
    public function addServiceMocks(array $services): void
    {
        $builder = (new ContainerBuilderFactory())->create()->getContainer();

        array_walk($services, function ($service, $serviceId) use ($builder) {
            if ($builder->has($serviceId)) {
                $builder->set($serviceId, $service);
            }
        });

        $builder->compile();
        $container = ContainerFactory::getInstance();
        $reflection = new ReflectionClass($container);
        $property = $reflection->getProperty($this->getDIContainerPropertyName($reflection));
        $property->setValue($container, $builder);
    }

    protected function getDIContainerPropertyName(ReflectionClass $containerReflection): string
    {
        $property = current(array_filter($containerReflection->getProperties(), function (ReflectionProperty $property) {
            return stristr($property->getName(), 'container');
        }));

        if (!is_object($property) || !$property instanceof ReflectionProperty) {
            throw new \RuntimeException("can't find container property");
        }

        return $property->getName();
    }
}
