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

namespace D3\TestingTools\Tests\Unit\Production;

use D3\TestingTools\Development\CanAccessRestricted;
use D3\TestingTools\Production\IsMockable;
use D3\TestingTools\Tests\Unit\Production\HelperClasses\IsMockableClass;
use D3\TestingTools\Tests\Unit\Production\HelperClasses\IsMockableParent;
use OxidEsales\Eshop\Application\Model\Article;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use RuntimeException;

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
        $methodName = $this->getRandomString();
        $argument   = $this->getRandomString();

        $traitMock = $this->getObjectForTrait(IsMockable::class);

        // argument #1 is not a valid callable
        $this->expectError();

        $this->callMethod(
            $traitMock,
            'd3CallMockableFunction',
            [[$traitMock, $methodName], [$argument]]
        );
    }

    /**
     * @param $fqClassName
     * @param $expected
     * @test
     * @throws ReflectionException
     * @dataProvider callMockableFunctionFromClassDataProvider
     * @covers \D3\TestingTools\Production\IsMockable::d3CallMockableFunction
     */
    public function callMockableFunctionFromClass($fqClassName, $expected): void
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

    /**
     * @return array[]
     */
    public function callMockableFunctionFromClassDataProvider()
    {
        return [
            'parent static method' => [IsMockableParent::class, 'ParentClass::myMethod##'],
            'current static method' => [IsMockableClass::class, 'currentClass::myMethod##'],
            'current object method' => ['mockObject', 'currentClass::myMethod##']
        ];
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
