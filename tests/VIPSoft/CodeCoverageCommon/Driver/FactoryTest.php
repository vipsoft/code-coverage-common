<?php
/**
 * Code Coverage Driver Factory
 *
 * @copyright 2013 Anthon Pang
 * @license BSD-2-Clause
 */

namespace VIPSoft\CodeCoverageCommon\Driver;

use VIPSoft\TestCase;
use VIPSoft\CodeCoverageCommon\Driver\Factory;

/**
 * Driver factory test
 *
 * @group Unit
 */
class FactoryTest extends TestCase
{
    public function testCreateNoClasses()
    {
        $factory = new Factory(array());

        $driver = $factory->create();

        $this->assertTrue($driver === null);
    }

    public function testCreate()
    {
        if ( ! class_exists('VIPSoft\CodeCoverageCommon\Driver\Factory\GoodDriver')) {
            eval(<<<END_OF_CLASS_DEFINITION
namespace VIPSoft\CodeCoverageCommon\Driver\Factory {
    class GoodDriver implements \PHP_CodeCoverage_Driver
    {
        public function __construct()
        {
        }

        public function start()
        {
        }

        public function stop()
        {
        }
    }
}
END_OF_CLASS_DEFINITION
            );
        }

        $classes = array(
            'VIPSoft\CodeCoverageCommon\Driver\Factory\GoodDriver',
        );

        $factory = new Factory($classes);

        $driver = $factory->create();

        $this->assertTrue($driver !== null);
    }

    public function testCreateException()
    {
        if ( ! class_exists('VIPSoft\CodeCoverageCommon\Driver\Factory\BadDriver')) {
            eval(<<<END_OF_CLASS_DEFINITION
namespace VIPSoft\CodeCoverageCommon\Driver\Factory {
    class BadDriver implements \PHP_CodeCoverage_Driver
    {
        public function __construct()
        {
            throw new \Exception('bad');
        }

        public function start()
        {
        }

        public function stop()
        {
        }
    }
}
END_OF_CLASS_DEFINITION
            );
        }

        $classes = array(
            'VIPSoft\CodeCoverageCommon\Driver\Factory\BadDriver',
        );

        $factory = new Factory($classes);

        $driver = $factory->create();

        $this->assertTrue($driver === null);
    }
}
