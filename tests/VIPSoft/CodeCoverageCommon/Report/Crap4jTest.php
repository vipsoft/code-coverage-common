<?php
/**
 * Crap4j Report
 *
 * @copyright 2013 Anthon Pang
 * @license BSD-2-Clause
 */

namespace VIPSoft\CodeCoverageCommon\Report;

use VIPSoft\TestCase;
use VIPSoft\CodeCoverageCommon\Report\Factory;

/**
 * Crap4j report test
 *
 * @group Unit
 */
class Crap4jTest extends TestCase
{
    public function testProcess()
    {
        if ( ! class_exists('PHP_CodeCoverage_Report_Crap4j')) {
            $this->markTestSkipped();

            return;
        }

        $this->markTestIncomplete();
    }
}
