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

namespace D3\TestingTools\Tests\Unit\Production;

use D3\TestingTools\Development\CanAccessRestricted;
use D3\TestingTools\Production\IsMockable;
use D3\TestingTools\Tests\Unit\Production\HelperClasses\IsMockableClass;
use D3\TestingTools\Tests\Unit\Production\HelperClasses\IsMockableParent;
use Exception;
use Generator;
use OxidEsales\Eshop\Application\Model\Article;
use OxidEsales\Eshop\Core\Config;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use ReflectionException;

class IsMockableTest extends TestCase
{
    use CanAccessRestricted;

    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\TestingTools\Production\IsMockable::d3CallMockableFunction
     */
    public function callMockableFunctionMissingFunction(): void
    {
        set_error_handler(static function (int $errno, string $errstr): void {
            throw new Exception($errstr, $errno);
        }, E_USER_WARNING);

        $methodName = $this->getRandomString();
        $argument   = $this->getRandomString();

        $traitMock = $this->getObjectForTrait(IsMockable::class);

        // argument #1 is not a valid callable
        $this->expectExceptionMessage('must be of type callable, array given');

        $this->callMethod(
            $traitMock,
            'd3CallMockableFunction',
            [[$traitMock, $methodName], [$argument]]
        );

        restore_error_handler();
    }

    /**
     * @param string $fqClassName
     * @param string $expected
     *
     * @throws ReflectionException
     * @test
     * @dataProvider callMockableFunctionFromClassDataProvider
     * @covers       \D3\TestingTools\Production\IsMockable::d3CallMockableFunction
     */
    public function callMockableFunctionFromClass(string $fqClassName, string $expected): void
    {
        $methodName = 'myMethod';
        $argument   = $this->getRandomString();

        /** @var MockObject $mock */
        $mock = new(IsMockableClass::class);

        if ($fqClassName === 'mockObject') {
            $fqClassName = $mock;
        }

        $this->assertSame(
            $expected.$argument,
            $this->callMethod(
                $mock,
                'd3CallMockableFunction',
                [[$fqClassName, $methodName], [$argument]]
            )
        );
    }

    public function callMockableFunctionFromClassDataProvider(): Generator
    {
        yield 'parent static method' => [IsMockableParent::class, 'ParentClass::myMethod##'];
        yield 'current static method' => [IsMockableClass::class, 'currentClass::myMethod##'];
        yield 'current object method' => ['mockObject', 'currentClass::myMethod##'];
    }

    /**
     * @test
     * @return void
     * @throws ReflectionException
     * @covers \D3\TestingTools\Production\IsMockable::d3GetMockableOxNewObject
     */
    public function canGetMockableOxNewObject()
    {
        /** @var MockObject $mock */
        $mock = new(IsMockableClass::class);

        $this->assertInstanceOf(
            Article::class,
            $this->callMethod(
                $mock,
                'd3GetMockableOxNewObject',
                [Article::class]
            )
        );
    }

    /**
     * @test
     * @return void
     * @throws ReflectionException
     * @covers \D3\TestingTools\Production\IsMockable::d3GetMockableRegistryObject
     */
    public function canGetMockableRegistryObject(): void
    {
        /** @var MockObject $mock */
        $mock = new(IsMockableClass::class);

        $this->assertInstanceOf(
            Config::class,
            $this->callMethod(
                $mock,
                'd3GetMockableRegistryObject',
                [Config::class]
            )
        );
    }

    /**
     * @test
     * @return void
     * @throws ReflectionException
     * @covers \D3\TestingTools\Production\IsMockable::d3GetMockableLogger
     */
    public function canGetMockableLogger()
    {
        /** @var MockObject $mock */
        $mock = new(IsMockableClass::class);

        $this->assertInstanceOf(
            LoggerInterface::class,
            $this->callMethod(
                $mock,
                'd3GetMockableLogger',
                [Config::class]
            )
        );
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
