<?php

namespace Mellivora\MultiProcess\Tests;

/**
 * @internal
 */
class HelperTest extends TestCase
{
    public function testOS()
    {
        $this->assertTrue(is_cli());

        if (stripos(PHP_OS, 'darwin') === 0) {
            $this->assertSame(os(), OS_DARWIN);
            $this->assertTrue(is_darwin());
        } elseif (stripos(PHP_OS, 'linux') === 0) {
            $this->assertSame(os(), OS_LINUX);
            $this->assertTrue(is_linux());
        } else {
            $this->assertSame(os(), OS_UNIX);
            $this->assertTrue(is_unix());
        }
    }

    public function testPid()
    {
        $this->assertSame(getmypid(), pid());
    }
}
