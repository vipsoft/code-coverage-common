<?php
/**
 * Clover Report
 *
 * @copyright 2013 Anthon Pang
 * @license BSD-2-Clause
 */

namespace VIPSoft\CodeCoverageCommon\Report;

use VIPSoft\TestCase;
use VIPSoft\CodeCoverageCommon\Report\Factory;

/**
 * Clover report test
 *
 * @group Unit
 */
class CloverTest extends TestCase
{
    public function testProcess()
    {
        $report = $this->getMockBuilder('PHP_CodeCoverage_Report_Node_File')
                       ->disableOriginalConstructor()
                       ->getMock();

        $coverage = $this->getMock('PHP_CodeCoverage');
        $coverage->expects($this->once())
                 ->method('getReport')
                 ->will($this->returnValue($report));

        $report = new Clover(array());
        $result = $report->process($coverage);

        $this->assertTrue(strpos($result, '<?xml version="1.0" encoding="UTF-8"?>') === 0);
    }
}
