<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * ExecutionTimeTest.php 
 *
 * PHP Version 5
 * 
 * @category  Test
 * @package   PHP_Shell
 * @author    Jesús Espino <jespinog@gmail.com>
 * @copyright 2010 Jesús Espino
 * @license   MIT <http://www.opensource.org/licenses/mit-license.php>
 * @version   SVN: $Id:$
 * @link      http://pear.php.net/package/PHP_Shell
 */


require_once 'PHP/Shell.php';
require_once "PHP/Shell/Extensions/ExecutionTime.php";

/**
 * ExecutionTimeTest 
 * 
 * @uses      PHPUnit_Framework_TestCase
 * @category  Test
 * @package   PHP_Shell
 * @author    Jesús Espino <jespinog@gmail.com>
 * @copyright 2010 Jesús Espino
 * @license   MIT <http://www.opensource.org/licenses/mit-license.php>
 * @version   Release: @package_version@
 * @link      http://pear.php.net/package/PHP_Shell
 */
class ExecutionTimeTest extends PHPUnit_Framework_TestCase
{
    private $_vars;
    private $_shell_exts;

    /**
     * setUp 
     * 
     * @access public
     * @return void
     */
    public function setUp()
    {
        /* create a fresh shell extensions object */
        $this->_shell_exts = PHP_Shell_Extensions::getInstance();
        $this->_shell_exts->registerExtensions(
            array(
                "options"        => PHP_Shell_Options::getInstance(),
                "exectime"           => new PHP_Shell_Extensions_ExecutionTime(),
            )
        );
    }

    /**
     * testOptSetExecTime 
     *
     * Test the optSetExecTime and test the isShow
     * 
     * @access public
     * @return void
     */
    public function testOptSetExecTime()
    {
        // Check that enable the exectime on valid enable string
        $this->_shell_exts->exectime->optSetExecTime('exectime', 'enable');
        $this->assertTrue($this->_shell_exts->exectime->isShow());
        $this->_shell_exts->exectime->optSetExecTime('exectime', 'on');
        $this->assertTrue($this->_shell_exts->exectime->isShow());
        $this->_shell_exts->exectime->optSetExecTime('exectime', '1');
        $this->assertTrue($this->_shell_exts->exectime->isShow());

        // Check that disable the exectime on valid disable string
        $this->_shell_exts->exectime->optSetExecTime('exectime', 'disable');
        $this->assertFalse($this->_shell_exts->exectime->isShow());
        $this->_shell_exts->exectime->optSetExecTime('exectime', 'off');
        $this->assertFalse($this->_shell_exts->exectime->isShow());
        $this->_shell_exts->exectime->optSetExecTime('exectime', '0');
        $this->assertFalse($this->_shell_exts->exectime->isShow());

        // Check that disable the exectime on not valid string
        ob_start();
        $this->_shell_exts->exectime->optSetExecTime('exectime', 'notvalid');
        $this->assertEquals(
            ob_get_clean(),
            ":set exectime failed, unknown value. Use :set exectime = (on|off)"
        );
    }

    /**
     * testGetTimes 
     * 
     * @access public
     * @return void
     */
    function testGetTimes()
    {
        $this->_shell_exts->exectime->startParseTime();
        sleep(1);
        $this->_shell_exts->exectime->startExecTime();
        sleep(1);
        $this->_shell_exts->exectime->stopTime();
        $parsetime = $this->_shell_exts->exectime->getParseTime();
        $exectime = $this->_shell_exts->exectime->getExecTime();
        $this->assertTrue($parsetime>1);
        $this->assertTrue($exectime>1);
    }
}

