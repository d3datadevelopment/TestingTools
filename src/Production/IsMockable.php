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

namespace D3\TestingTools\Production;

use OxidEsales\Eshop\Core\Registry;
use Psr\Log\LoggerInterface;

trait IsMockable
{
    /**
     * mockable wrapper for uncertain parent calls
     *
     * @param callable $callable
     * @param array  $arguments
     *
     * @return false|mixed
     */
    protected function d3CallMockableFunction(callable $callable, array $arguments = []): mixed
    {
        return call_user_func_array($callable, $arguments);
    }

    /**
     * for mocking use callback:
     *
     * $object->method('d3GetMockableOxNewObject')->willReturnCallback(
     *   function () use ($manufacturerMock) {
     *     $args = func_get_args();
     *     switch ($args[0]) {
     *       case Article::class:
     *         return $manufacturerMock;
     *       default:
     *         return call_user_func_array("oxNew", $args);
     *     }
     *   }
     * );
     *
     * @template T
     * @param class-string<T> $className
     * @param mixed  ...$args   constructor arguments
     *
     * @return T
     */
    protected function d3GetMockableOxNewObject(string $className, mixed ...$args)
    {
        $arguments = func_get_args();
        return call_user_func_array("oxNew", $arguments);
    }

    /**
     * for mocking use callback:
     *
     * $object->method('d3GetMockableRegistryObject')->willReturnCallback(
     *   function () use ($utilsServerMock) {
     *     $args = func_get_args();
     *     switch ($args[0]) {
     *       case UtilsServer::class:
     *         return $utilsServerMock;
     *       default:
     *         return Registry::get($args[0]);
     *     }
     *   }
     *
     * @template T
     * @param class-string<T> $className
     *
     * @return T
     */
    protected function d3GetMockableRegistryObject(string $className)
    {
        return Registry::get($className);
    }

    /**
     * @return LoggerInterface
     */
    public function d3GetMockableLogger(): LoggerInterface
    {
        return Registry::getLogger();
    }
}
