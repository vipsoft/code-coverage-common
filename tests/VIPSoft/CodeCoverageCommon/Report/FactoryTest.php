<?php
/**
 * Code Coverage Report Factory
 *
 * @copyright 2013 Anthon Pang
 * @license BSD-2-Clause
 */

namespace VIPSoft\CodeCoverageCommon;

use VIPSoft\TestCase;
use VIPSoft\CodeCoverageCommon\Report\Factory;

/**
 * Factory test
 *
 * @group Unit
 */
class FactoryTest extends TestCase
{
    /**
     * @dataProvider legacyCreateProvider
     */
    public function testLegacyCreate($expected, $reportType)
    {
        $factory = new Factory();

        $this->assertEquals($expected, get_class($factory->create($reportType, array())));
    }

    public function legacyCreateProvider()
    {
        return array(
            array(
                'VIPSoft\CodeCoverageCommon\Report\Clover',
                'clover',
            ),
            array(
                'VIPSoft\CodeCoverageCommon\Report\Html',
                'html',
            ),
            array(
                'VIPSoft\CodeCoverageCommon\Report\Php',
                'php',
            ),
            array(
                'VIPSoft\CodeCoverageCommon\Report\Text',
                'text',
            ),
        );
    }

    /**
     * @dataProvider createProvider
     */
    public function testCreate($expected, $reportType)
    {
        $factory = new Factory();

        try {
            $this->assertEquals($expected, get_class($factory->create($reportType, array())));
        } catch (\Exception $e) {
            $this->assertTrue(strpos($e->getMessage(), 'requires PHP_CodeCoverage 1.3+') !== false);
        }
    }

    public function createProvider()
    {
        return array(
            array(
                'VIPSoft\CodeCoverageCommon\Report\Crap4j',
                'crap4j',
            ),
            array(
                'VIPSoft\CodeCoverageCommon\Report\Xml',
                'xml',
            ),
        );
    }

    public function testCreateInvalid()
    {
        $factory = new Factory();

        $this->assertTrue($factory->create('HTML', array()) === null);
    }
}
