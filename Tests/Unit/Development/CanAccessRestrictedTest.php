<?php

/**
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * https://www.d3data.de
 *
 * @copyright (C) D3 Data Development (Inh. Thomas Dartsch)
 * @author    D3 Data Development - Daniel Seifert <info@shopmodule.com>
 * @link      https://www.oxidmodule.com
 */

declare(strict_types=1);

namespace D3\TestingTools\Tests\Unit\Development;

use D3\TestingTools\Development\CanAccessRestricted;
use D3\TestingTools\Tests\Unit\Development\HelperClasses\CanAccessRestrictedClass;
use Error;
use PHPUnit\Framework\TestCase;
use ReflectionException;

class CanAccessRestrictedTest extends TestCase
{
    use CanAccessRestricted;

    /** @var CanAccessRestrictedClass */
    public $class;

    public function setUp(): void
    {
        parent::setUp();

        $this->class = new CanAccessRestrictedClass();
    }

    /**
     * @test
     *
     * @param string $methodName
     * @param bool   $accessible
     *
     * @dataProvider canCallMethodDataProvider
     */
    public function canCallMethod(string $methodName, bool $accessible): void
    {
        $args = $this->getRandomString();
        $expected = 'D3\TestingTools\Tests\Unit\Development\HelperClasses\CanAccessRestrictedClass::'.$methodName.'##'.$args;

        if (!$accessible) {
            $this->expectException(Error::class);
        }

        $this->assertSame(
            $expected,
            $this->class->{$methodName}($args)
        );
    }

    /**
     * @param string $methodName
     *
     * @test
     * @throws ReflectionException
     * @dataProvider canCallMethodDataProvider
     * @covers \D3\TestingTools\Development\CanAccessRestricted::callMethod()
     */
    public function canCallMethodViaReflection(string $methodName): void
    {
        $args = $this->getRandomString();
        $expected = 'D3\TestingTools\Tests\Unit\Development\HelperClasses\CanAccessRestrictedClass::'.$methodName.'##'.$args;

        $this->assertSame(
            $expected,
            $this->callMethod(
                $this->class,
                $methodName,
                [$args]
            )
        );
    }

    /**
     * @return array
     */
    public function canCallMethodDataProvider(): array
    {
        return [
            'public method'         => ['publicMethod', true],
            'protected method'      => ['protectedMethod', false],
            'private method'        => ['privateMethod', false],
            'final public method'   => ['finalPublicMethod', true],
        ];
    }

    /**
     * @test
     * @param string $propertyName
     * @param bool   $accessible
     * @dataProvider canSetAndGetClassPropertiesDataProvider
     */
    public function canSetAndGetClassProperties(string $propertyName, bool $accessible): void
    {
        $args = $this->getRandomString();

        if (!$accessible) {
            $this->expectException(Error::class);
        }

        $this->class->{$propertyName} = $args;

        $this->assertSame(
            $args,
            $this->class->{$propertyName}
        );
    }

    /**
     * @test
     *
     * @param string $propertyName
     *
     * @throws ReflectionException
     * @dataProvider canSetAndGetClassPropertiesDataProvider
     * @covers       \D3\TestingTools\Development\CanAccessRestricted::setValue()
     * @covers       \D3\TestingTools\Development\CanAccessRestricted::getValue()
     */
    public function canSetAndGetClassPropertiesViaReflections(string $propertyName): void
    {
        $args = $this->getRandomString();

        $this->setValue(
            $this->class,
            $propertyName,
            $args
        );

        $this->assertSame(
            $args,
            $this->getValue(
                $this->class,
                $propertyName
            )
        );
    }

    /**
     * @return array
     */
    public function canSetAndGetClassPropertiesDataProvider(): array
    {
        return [
            'public property'         => ['publicProperty', true],
            'protected property'      => ['protectedProperty', false],
            'private property'        => ['privateProperty', false],
        ];
    }

    /**
     * @test
     * @param string $propertyName
     * @param bool   $accessible
     * @dataProvider canSetAndGetMockedPropertiesDataProvider
     */
    public function canSetAndGetMockedClassProperties(string $propertyName, bool $accessible): void
    {
        $this->class = $this->getMockBuilder(CanAccessRestrictedClass::class)
            ->getMock();

        $args = $this->getRandomString();

        if (!$accessible) {
            $this->expectException(Error::class);
        }

        $this->class->{$propertyName} = $args;

        $this->assertSame(
            $args,
            $this->class->{$propertyName}
        );
    }

    /**
     * @test
     *
     * @param string $propertyName
     *
     * @throws ReflectionException
     * @dataProvider canSetAndGetClassPropertiesDataProvider
     * @covers       \D3\TestingTools\Development\CanAccessRestricted::setMockedClassValue()
     * @covers       \D3\TestingTools\Development\CanAccessRestricted::getMockedClassValue()
     */
    public function canSetAndGetClassMockedPropertiesViaReflections(string $propertyName): void
    {
        $mock = $this->getMockBuilder(CanAccessRestrictedClass::class)
            ->getMock();

        $args = $this->getRandomString();

        $this->setMockedClassValue(
            CanAccessRestrictedClass::class,
            $mock,
            $propertyName,
            $args
        );

        $this->assertSame(
            $args,
            $this->getMockedClassValue(
                CanAccessRestrictedClass::class,
                $mock,
                $propertyName
            )
        );
    }

    /**
     * @return array
     */
    public function canSetAndGetMockedPropertiesDataProvider(): array
    {
        return [
            'public property'         => ['publicProperty', true],
            'protected property'      => ['protectedProperty', false],
            'private property'        => ['privateProperty', true], // because private properties not contained in mock
        ];
    }

    /**
     * @param int $length
     *
     * @return string
     */
    protected function getRandomString(int $length = 20): string
    {
        return substr(
            str_shuffle(
                str_repeat(
                    $x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
                    (int) ceil($length/strlen($x))
                )
            ),
            1,
            $length
        );
    }
}
