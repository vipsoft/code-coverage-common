<?php
/**
 * Text Report
 *
 * @copyright 2013 Anthon Pang
 * @license BSD-2-Clause
 */

namespace VIPSoft\CodeCoverageCommon\Report;

use VIPSoft\TestCase;
use VIPSoft\CodeCoverageCommon\Report\Factory;

/**
 * Text report test
 *
 * @group Unit
 */
class TextTest extends TestCase
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

        $report = new Text(array());
        ob_start();
        $report->process($coverage);
        $result = ob_get_clean();

        $this->assertTrue(strpos($result, 'Code Coverage Report') !== false);
    }
}
