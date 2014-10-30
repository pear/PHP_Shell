<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * AutoloadDebugTest.php 
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
require_once "PHP/Shell/Extensions/AutoloadDebug.php";

/**
 * AutoloadDebugTest 
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
class AutoloadDebugTest extends PHPUnit_Framework_TestCase
{
    /**
     * _vars 
     * 
     * @var mixed
     * @access private
     */
    private $_vars;
    /**
     * _shell_exts 
     * 
     * @var mixed
     * @access private
     */
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
                "autoloaddebug"  => new PHP_Shell_Extensions_AutoloadDebug(),
            )
        );
    }

    /**
     * testIsAutoloadDebugEnabled 
     * 
     * @access public
     * @return void
     */
    public function testIsAutoloadDebug()
    {
        $this->assertFalse($this->_shell_exts->autoloaddebug->isAutoloadDebug());
        $this->_shell_exts->autoloaddebug->optSetAutoloadDebug(
            "autoloaddebug",
            "on"
        );
        $this->assertTrue($this->_shell_exts->autoloaddebug->isAutoloadDebug());
    }

    /**
     * testOptSetAutoloadDebug 
     *
     * Test the optSetAutoloadDebug and test the isEcho
     * 
     * @access public
     * @return void
     */
    public function testOptSetAutoloadDebug()
    {
        $this->_shell_exts->autoloaddebug->optSetAutoloadDebug(
            "autoloaddebug",
            "on"
        );
        $this->_shell_exts->autoloaddebug->optSetAutoloadDebug(
            "autoloaddebug",
            "off"
        );
        ob_start();
        $this->_shell_exts->autoloaddebug->optSetAutoloadDebug(
            "autoloaddebug",
            "notvalid"
        );
        $this->assertEquals(
            ob_get_clean(),
            ":set autoloaddebug failed, unknown value. ".
            "Use :set autoloaddebug = (on|off)"
        );
    }

    /**
     * testIncAutoloadDepth 
     * 
     * @access public
     * @return void
     */
    public function testIncAutoloadDepth()
    {
        $this->assertEquals(
            0,
            $this->_shell_exts->autoloaddebug->incAutoloadDepth()
        );
        $this->assertEquals(
            1,
            $this->_shell_exts->autoloaddebug->incAutoloadDepth()
        );
    }

    /**
     * testDecAutoloadDepth 
     * 
     * @access public
     * @return void
     */
    public function testDecAutoloadDepth()
    {
        $this->assertEquals(
            -1,
            $this->_shell_exts->autoloaddebug->decAutoloadDepth()
        );
        $this->assertEquals(
            -2,
            $this->_shell_exts->autoloaddebug->decAutoloadDepth()
        );
    }
}

