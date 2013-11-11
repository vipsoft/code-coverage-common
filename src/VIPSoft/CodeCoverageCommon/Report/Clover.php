<?php
/**
 * Code Coverage Clover Report
 *
 * @copyright 2013 Anthon Pang
 * @license BSD-3-Clause
 */

namespace VIPSoft\CodeCoverageCommon\Report;

use VIPSoft\CodeCoverageCommon\ReportInterface;

/**
 * Clover report
 *
 * @author Anthon Pang <apang@softwaredevelopment.ca>
 */
class Clover implements ReportInterface
{
    /**
     * @var \PHP_CodeCoverage_Report_Clover
     */
    private $report;

    /**
     * @var array
     */
    private $options;

    /**
     * {@inheritdoc}
     */
    public function __construct(array $options)
    {
        if ( ! isset($options['target'])) {
            $options['target'] = null;
        }

        if ( ! isset($options['name'])) {
            $options['name'] = null;
        }

        $this->report = new \PHP_CodeCoverage_Report_Clover();
        $this->options = $options;
    }

    /**
     * {@inheritdoc}
     */
    public function process(\PHP_CodeCoverage $coverage)
    {
        return $this->report(
            $coverage,
            $options['target'],
            $options['name']
        );
    }
}
