<?php

namespace Mellivora\MultiProcess\Tests;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;

/**
 * 在这里对单元测试进行初始化设置
 */
abstract class TestCase extends PHPUnitTestCase
{
    protected function setUp()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', true);
        ini_set('html_errors', false);
    }

    public static function assertStringContains($haystack, $needle)
    {
        return self::assertTrue(
            is_string($needle) && strpos($haystack, $needle) !== false
        );
    }

    public static function assertStringNotContains($haystack, $needle)
    {
        return self::assertTrue(
            is_string($needle) && strpos($haystack, $needle) === false
        );
    }
}
