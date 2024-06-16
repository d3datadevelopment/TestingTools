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

namespace D3\TestingTools\Tests\Unit\Production\HelperClasses;

use D3\TestingTools\Production\IsMockable;

class IsMockableClass extends IsMockableParent
{
    use IsMockable;

    /**
     * @param string $arg
     *
     * @return string
     */
    public function myMethod(string $arg): string
    {
        return 'currentClass::myMethod##'.$arg;
    }

    public function fakeMethod(): void
    {
    }
}
