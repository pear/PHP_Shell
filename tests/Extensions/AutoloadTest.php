<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * AutoloadTest.php 
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
require_once "PHP/Shell/Extensions/Autoload.php";

/**
 * AutoloadTest 
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
class AutoloadTest extends PHPUnit_Framework_TestCase
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
                "autoload"           => new PHP_Shell_Extensions_Autoload(),
                "autoload2"           => new PHP_Shell_Extensions_Autoload(),
                "autoload3"           => new PHP_Shell_Extensions_Autoload(),
            )
        );
    }

    /**
     * testIsAutoloadEnabled 
     * 
     * @access public
     * @return void
     */
    public function testIsAutoloadEnabled()
    {
        $this->assertFalse($this->_shell_exts->autoload3->isAutoloadEnabled());
        $this->_shell_exts->autoload3->optSetAutoload("", "");
        $this->assertTrue($this->_shell_exts->autoload3->isAutoloadEnabled());
    }

    /**
     * testOptSetAutoload 
     *
     * Test the optSetAutoload and test the isEcho
     * 
     * @access public
     * @return void
     */
    public function testOptSetAutoload()
    {
        $this->_shell_exts->autoload->optSetAutoload("", "");
        /**
         * Function __autoload for a better coverage 
         *
         * @return void
         */
        function __autoload()
        {
        }
        ob_start();
        $this->_shell_exts->autoload2->optSetAutoload("", "");
        $this->assertEquals(
            ob_get_clean(),
            "can't enabled autoload as a external ".
            "__autoload() function is already defined"
        );
        ob_start();
        $this->_shell_exts->autoload->optSetAutoload("", "");
        $this->assertEquals(
            ob_get_clean(),
            "autoload is already enabled"
        );
    }
}

