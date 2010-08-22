<?php
/**
 * AllTests.php Execution class for all tests
 *
 * PHP version 5
 *
 * @category  Test
 * @package   PHP_Shell
 * @author    Jan Kneschke <jan@kneschke.de>
 * @copyright 2006 Jan Kneschke
 * @license   MIT <http://www.opensource.org/licenses/mit-license.php>
 * @version   SVN: $Id$
 * @link      http://pear.php.net/package/PHP_Shell
 */

if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'PHP_Shell_AllTests::main');
}

require_once 'PHPUnit/TextUI/TestRunner.php';
require_once 'PHPUnit/Framework/TestSuite.php';

require_once 'ShellTest.php';
require_once 'ExtensionsTest.php';
require_once 'OptionsTest.php';
require_once 'Extensions/AutoloadDebugTest.php';
require_once 'Extensions/AutoloadTest.php';
require_once 'Extensions/ColourTest.php';
require_once 'Extensions/EchoTest.php';
require_once 'Extensions/ExecutionTimeTest.php';
require_once 'Extensions/InlineHelpTest.php';
require_once 'Extensions/LoadScriptTest.php';
require_once 'Extensions/VerbosePrintTest.php';

/**
 * PHP_Shell_AllTests
 * 
 * @category  Test
 * @package   PHP_Shell
 * @author    Jan Kneschke <jan@kneschke.de>
 * @copyright 2006 Jan Kneschke
 * @license   MIT <http://www.opensource.org/licenses/mit-license.php>
 * @version   Release: @package_version@
 * @link      http://pear.php.net/package/PHP_Shell
 */
class PHP_Shell_AllTests
{
    /**
     * main Run all tests
     * 
     * @static
     * @access public
     * @return void
     */
    public static function main()
    {
        PHPUnit_TextUI_TestRunner::run(self::suite());
    }

    /**
     * suite Return the suite for test PHP_Shell
     * 
     * @static
     * @access public
     * @return void
     */
    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite( "Shell Tests");
        $suite->addTestSuite('ShellTest');
        $suite->addTestSuite('ExtensionsTest');
        $suite->addTestSuite('OptionsTest');
        $suite->addTestSuite('AutoloadDebugTest');
        $suite->addTestSuite('AutoloadTest');
        $suite->addTestSuite('ColourTest');
        $suite->addTestSuite('EchoTest');
        $suite->addTestSuite('ExecutionTimeTest');
        $suite->addTestSuite('InlineHelpTest');
        $suite->addTestSuite('LoadScriptTest');
        $suite->addTestSuite('VerbosePrintTest');
        return $suite;
    }

}

if (PHPUnit_MAIN_METHOD == 'PHP_Shell_AllTests::main') {
    PHP_Shell_AllTests::main();
}

