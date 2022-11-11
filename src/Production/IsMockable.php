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

use RuntimeException as RuntimeExceptionAlias;

trait IsMockable
{
    /**
     * mockable wrapper for uncertain parent calls
     *
     * @param string $methodName
     * @param array  $arguments
     *
     * @return false|mixed
     */
    protected function d3CallMockableParent(string $methodName, array $arguments = [])
    {
        if (get_parent_class($this)) {
            /** @var callable $callable */
            $callable = [ parent::class, $methodName ];
            return call_user_func_array($callable, $arguments);
        }

        throw new RuntimeExceptionAlias('Cannot use "parent" when current class scope has no parent');
    }
}
