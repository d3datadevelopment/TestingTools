<?php

/**
 * This Software is the property of Data Development and is protected
 * by copyright law - it is NOT Freeware.
 * Any unauthorized use of this software without a valid license
 * is a violation of the license agreement and will be prosecuted by
 * civil and criminal law.
 * http://www.shopmodule.com
 *
 * @copyright (C) D3 Data Development (Inh. Thomas Dartsch)
 * @author        D3 Data Development - Daniel Seifert <support@shopmodule.com>
 * @link          http://www.oxidmodule.com
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
