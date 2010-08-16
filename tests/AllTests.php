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
 * @version   SVN: $id$
 * @link      http://pear.php.net/package/PHP_Shell
 */

if (!defined('PHPUNIT_MAIN_METHOD')) {
    define('PHPUNIT_MAIN_METHOD', 'PHP_Shell_AllTests::main');
}

require_once 'PHPUnit/TextUI/TestRunner.php';
require_once 'PHPUnit/Framework/TestSuite.php';

require_once 'ShellTest.php';

/**
 * PHP_Shell_AllTests
 * 
 * @category  Test
 * @package   PHP_Shell
 * @author    Jan Kneschke <jan@kneschke.de>
 * @copyright 2006 Jan Kneschke
 * @license   MIT <http://www.opensource.org/licenses/mit-license.php>
 * @version   Release: $id$
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
        return $suite;
    }

}

if (PHPUNIT_MAIN_METHOD == 'PHP_Shell_AllTests::main') {
    PHP_Shell_AllTests::main();
}

