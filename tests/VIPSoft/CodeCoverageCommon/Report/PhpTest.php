<?php
/**
 * PHP Report
 *
 * @copyright 2013 Anthon Pang
 * @license BSD-2-Clause
 */

namespace VIPSoft\CodeCoverageCommon\Report;

use VIPSoft\TestCase;
use VIPSoft\CodeCoverageCommon\Report\Factory;

/**
 * PHP report test
 *
 * @group Unit
 */
class PhpTest extends TestCase
{
    public function testProcess()
    {
        $coverage = $this->getMock('PHP_CodeCoverage');

        $report = new PHP(array());
        $result = $report->process($coverage);

        $this->assertTrue(strncmp($result, 'O:', 2) === 0);
    }
}
