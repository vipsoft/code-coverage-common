<?php
/**
 * Code Coverage Driver 
 *
 * @copyright 2013 Anthon Pang
 * @license BSD-2-Clause
 */

namespace VIPSoft\CodeCoverageCommon;

use VIPSoft\TestCase;
use VIPSoft\CodeCoverageCommon\Driver;

/**
 * Driver test
 *
 * @group Unit
 */
class DriverTest extends TestCase
{
    public function testConstructNoExtensions()
    {
        $this->getMockFunction('extension_loaded', function () {
            return false;
        });

        try {
            new Driver();

            $this->fail();
        } catch (\Exception $e) {
            $this->assertTrue($e instanceof \PHP_CodeCoverage_Exception);
            $this->assertEquals('Xdebug (or XCache) is not loaded.', $e->getMessage());
        }
    }

    public function testConstructXdebugCoverageNotEnabled()
    {
        $this->getMockFunction('extension_loaded', function () {
            return true;
        });

        $this->getMockFunction('phpversion', function () {
            return '2.2.0';
        });

        $this->getMockFunction('ini_get', function () {
            return false;
        });

        try {
            new Driver();

            $this->fail();
        } catch (\Exception $e) {
            $this->assertTrue($e instanceof \PHP_CodeCoverage_Exception);
            $this->assertEquals('You need to set xdebug.coverage_enable=On in your php.ini.', $e->getMessage());
        }
    }

    public function testConstructXCacheCoverageNotEnabled()
    {
        $function = $this->getMock('VIPSoft\Test\FunctionProxy');
        $function->expects($this->exactly(2))
                 ->method('invokeFunction')
                 ->will($this->onConsecutiveCalls(
                     false,
                     true
                 ));

        $this->getMockFunction('extension_loaded', $function);

        $this->getMockFunction('phpversion', function () {
            return '3.1.0';
        });

        $this->getMockFunction('ini_get', function () {
            return false;
        });

        try {
            new Driver();

            $this->fail();
        } catch (\Exception $e) {
            $this->assertTrue($e instanceof \PHP_CodeCoverage_Exception);
            $this->assertEquals('You need to set xcache.coverager=On in your php.ini.', $e->getMessage());
        }
    }

    public function testConstructXdebug()
    {
        $this->getMockFunction('extension_loaded', function () {
            return true;
        });

        $this->getMockFunction('phpversion', function () {
            return '2.2.0';
        });

        $this->getMockFunction('ini_get', function () {
            return true;
        });

        new Driver();
    }

    public function testConstructXCache()
    {
        $function = $this->getMock('VIPSoft\Test\FunctionProxy');
        $function->expects($this->exactly(2))
                 ->method('invokeFunction')
                 ->will($this->onConsecutiveCalls(
                     false,
                     true
                 ));

        $this->getMockFunction('extension_loaded', $function);

        $this->getMockFunction('phpversion', function () {
            return '3.1.0';
        });

        $this->getMockFunction('ini_get', function () {
            return true;
        });

        new Driver();
    }

    public function testStartXdebug()
    {
        $this->getMockFunction('extension_loaded', function () {
            return true;
        });

        $this->getMockFunction('phpversion', function () {
            return '2.2.0';
        });

        $this->getMockFunction('ini_get', function () {
            return true;
        });

        $function = $this->getMock('VIPSoft\Test\FunctionProxy');
        $function->expects($this->exactly(1))
                 ->method('invokeFunction');

        $this->getMockFunction('xdebug_start_code_coverage', $function);

        $driver = new Driver();
        $driver->start();
    }

    public function testStartXCache()
    {
        $function = $this->getMock('VIPSoft\Test\FunctionProxy');
        $function->expects($this->exactly(2))
                 ->method('invokeFunction')
                 ->will($this->onConsecutiveCalls(
                     false,
                     true
                 ));

        $this->getMockFunction('extension_loaded', $function);

        $this->getMockFunction('phpversion', function () {
            return '3.1.0';
        });

        $this->getMockFunction('ini_get', function () {
            return true;
        });

        $function = $this->getMock('VIPSoft\Test\FunctionProxy');
        $function->expects($this->exactly(1))
                 ->method('invokeFunction');

        $this->getMockFunction('xcache_coverager_start', $function);

        $driver = new Driver();
        $driver->start();
    }

    public function testStopXdebug()
    {
        $this->getMockFunction('extension_loaded', function () {
            return true;
        });

        $this->getMockFunction('phpversion', function () {
            return '2.2.0';
        });

        $this->getMockFunction('ini_get', function () {
            return true;
        });

        $function = $this->getMock('VIPSoft\Test\FunctionProxy');
        $function->expects($this->exactly(2))
                 ->method('invokeFunction');

        $this->getMockFunction('xdebug_get_code_coverage', $function);
        $this->getMockFunction('xdebug_stop_code_coverage', $function);

        $driver = new Driver();
        $driver->stop();
    }

    public function testStopXCache()
    {
        $function = $this->getMock('VIPSoft\Test\FunctionProxy');
        $function->expects($this->exactly(2))
                 ->method('invokeFunction')
                 ->will($this->onConsecutiveCalls(
                     false,
                     true
                 ));

        $this->getMockFunction('extension_loaded', $function);

        $this->getMockFunction('phpversion', function () {
            return '3.1.0';
        });

        $this->getMockFunction('ini_get', function () {
            return true;
        });

        $function = $this->getMock('VIPSoft\Test\FunctionProxy');
        $function->expects($this->exactly(2))
                 ->method('invokeFunction');

        $this->getMockFunction('xcache_coverager_get', $function);
        $this->getMockFunction('xcache_coverager_stop', $function);

        $driver = new Driver();
        $driver->stop();
    }
}
