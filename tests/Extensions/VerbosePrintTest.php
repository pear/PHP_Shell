<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * VerbosePrintTest.php 
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
require_once "PHP/Shell/Extensions/VerbosePrint.php";

/**
 * VerbosePrintTest 
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
class VerbosePrintTest extends PHPUnit_Framework_TestCase
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
                "verbose"           => new PHP_Shell_Extensions_VerbosePrint(),
            )
        );
    }

    /**
     * testCmdPrint 
     * 
     * @access public
     * @return void
     */
    public function testCmdPrint()
    {
        $expected = "command";
        $result = $this->_shell_exts->verbose->cmdPrint("p command");
        $this->assertEquals($result, $expected);
    }

    /**
     * testOptSetVerbose
     *
     * Test the optSetVerbosePrint and test the isEcho
     * 
     * @access public
     * @return void
     */
    public function testOptSetVerbose()
    {
        $this->_shell_exts->verbose->optSetVerbose("verbose", "true");
        $this->assertTrue($this->_shell_exts->verbose->isVerbose());
        $this->_shell_exts->verbose->optSetVerbose("verbose", "on");
        $this->assertTrue($this->_shell_exts->verbose->isVerbose());
        $this->_shell_exts->verbose->optSetVerbose("verbose", "1");
        $this->assertTrue($this->_shell_exts->verbose->isVerbose());

        $this->_shell_exts->verbose->optSetVerbose("verbose", "false");
        $this->assertFalse($this->_shell_exts->verbose->isVerbose());
        $this->_shell_exts->verbose->optSetVerbose("verbose", "off");
        $this->assertFalse($this->_shell_exts->verbose->isVerbose());
        $this->_shell_exts->verbose->optSetVerbose("verbose", "0");
        $this->assertFalse($this->_shell_exts->verbose->isVerbose());
        
        $this->_shell_exts->verbose->optSetVerbose("verbose", "other");
        $this->assertFalse($this->_shell_exts->verbose->isVerbose());
    }
}

