<?php
/**
 * Created by PhpStorm.
 * User: apremiera
 * Date: 22.01.19
 * Time: 12:41
 */

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class SimpleTest extends TestCase
{
    /**
     * testSimpleAssert
     */
    public function testSimpleAssert(): void
    {
        $a = array(1,2,3,4);

        $this->assertArrayHasKey(3, $a, 'Array has key 3');
    }
}