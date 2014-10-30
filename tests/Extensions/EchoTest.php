<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * EchoTest.php 
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
require_once "PHP/Shell/Extensions/Echo.php";

/**
 * EchoTest 
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
class EchoTest extends PHPUnit_Framework_TestCase
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
                "echo"           => new PHP_Shell_Extensions_Echo(),
            )
        );
    }

    /**
     * testOptSetEcho 
     *
     * Test the optSetEcho and test the isEcho
     * 
     * @access public
     * @return void
     */
    public function testOptSetEcho()
    {
        // Check that enable the echo on valid enable string
        $this->_shell_exts->echo->optSetEcho('echo', 'true');
        $this->assertTrue($this->_shell_exts->echo->isEcho());
        $this->_shell_exts->echo->optSetEcho('echo', 'on');
        $this->assertTrue($this->_shell_exts->echo->isEcho());
        $this->_shell_exts->echo->optSetEcho('echo', '1');
        $this->assertTrue($this->_shell_exts->echo->isEcho());

        // Check that disable the echo on valid disable string
        $this->_shell_exts->echo->optSetEcho('echo', 'false');
        $this->assertFalse($this->_shell_exts->echo->isEcho());
        $this->_shell_exts->echo->optSetEcho('echo', 'off');
        $this->assertFalse($this->_shell_exts->echo->isEcho());
        $this->_shell_exts->echo->optSetEcho('echo', '0');
        $this->assertFalse($this->_shell_exts->echo->isEcho());

        // Check that disable the echo on not valid string
        $this->_shell_exts->echo->optSetEcho('echo', 'aleatory string');
        $this->assertFalse($this->_shell_exts->echo->isEcho());
    }
}

