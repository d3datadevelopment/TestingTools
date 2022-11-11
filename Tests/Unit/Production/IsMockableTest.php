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
     */
    public function callMockableNoParent(): void
    {
        $methodName = $this->getRandomString();
        $argument   = $this->getRandomString();

        $traitMock = $this->getObjectForTrait(IsMockable::class);

        $this->expectException(RuntimeException::class);

        $this->callMethod(
            $traitMock,
            'd3CallMockableParent',
            [$methodName, [$argument]]
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function callMockableParent(): void
    {
        $methodName = 'myMethod';
        $argument   = $this->getRandomString();

        /** @var MockObject $mock */
        $mock = $this->getMockBuilder(IsMockableClass::class)
            ->getMock();
        // method from mocked class will never call, run method from parent class only
        $mock->expects($this->never())->method($methodName);

        $this->assertSame(
            'ParentClass::myMethod##'.$argument,
            $this->callMethod(
                $mock,
                'd3CallMockableParent',
                [$methodName, [$argument]]
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
