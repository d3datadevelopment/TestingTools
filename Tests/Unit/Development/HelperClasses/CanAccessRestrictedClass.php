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

namespace D3\TestingTools\Tests\Unit\Development\HelperClasses;

class CanAccessRestrictedClass
{
    /** @var string */
    public $publicProperty = 'publicProperty';

    /** @var string */
    protected $protectedProperty = 'protectedProperty';

    /** @var string */
    private $privateProperty = 'privateProperty';

    /**
     * @param string $arg
     *
     * @return string
     */
    public function publicMethod(string $arg): string
    {
        return __METHOD__.'##'.$arg;
    }

    /**
     * @param string $arg
     *
     * @return string
     */
    protected function protectedMethod(string $arg): string
    {
        return __METHOD__.'##'.$arg;
    }

    /**
     * @param string $arg
     *
     * @return string
     */
    private function privateMethod(string $arg): string
    {
        return __METHOD__.'##'.$arg;
    }

    /**
     * @param string $arg
     *
     * @return string
     */
    final public function finalPublicMethod(string $arg): string
    {
        return __METHOD__.'##'.$arg;
    }
}
