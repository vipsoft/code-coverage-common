<?php
/**
 * Code Coverage Driver
 *
 * @copyright 2013 Anthon Pang
 * @license BSD-3-Clause
 */

namespace VIPSoft\CodeCoverageCommon;

use \PHP_CodeCoverage_Driver as DriverInterface;

/**
 * Driver that auto-detects support for Xdebug and XCache
 *
 * {@internal Derived from PHP_CodeCoverage_Driver_Xdebug.}
 *
 * @author Anthon Pang <apang@softwaredevelopment.ca>
 */
class Driver implements DriverInterface
{
    private $driverType;

    /**
     * Constructor
     *
     * @throws \PHP_CodeCoverage_Exception if PHP code coverage not enabled
     */
    public function __construct()
    {
        if (extension_loaded('xdebug')) {
            if (version_compare(phpversion('xdebug'), '2.2.0-dev', '>=') &&
                ! ini_get('xdebug.coverage_enable')
            ) {
                throw new \PHP_CodeCoverage_Exception(
                    'You need to set xdebug.coverage_enable=On in your php.ini.'
                );
            }

            $this->driverType = 'xdebug';

            return;
        }

        if (extension_loaded('xcache')) {
            if (version_compare(phpversion('xcache'), '1.2.0', '<') ||
                ! ini_get('xcache.coverager')
            ) {
                throw new \PHP_CodeCoverage_Exception(
                    'You need to set xcache.coverager=On in your php.ini.'
                );
            }

            $this->driverType = 'xcache';

            return;
        }

        throw new \PHP_CodeCoverage_Exception('Xdebug (or XCache) is not loaded.');
    }

    /**
     * {@inheritdoc}
     */
    public function start()
    {
        switch ($this->driverType) {
            case 'xcache':
                xcache_coverager_start();
                break;
            case 'xdebug':
                xdebug_start_code_coverage(XDEBUG_CC_UNUSED | XDEBUG_CC_DEAD_CODE);
                break;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function stop()
    {
        switch ($this->driverType) {
            case 'xcache':
                $codeCoverage = xcache_coverager_get();

                xcache_coverager_stop(true);
                break;
            case 'xdebug':
                $codeCoverage = xdebug_get_code_coverage();

                xdebug_stop_code_coverage();
                break;
        }

        return $codeCoverage;
    }
}
