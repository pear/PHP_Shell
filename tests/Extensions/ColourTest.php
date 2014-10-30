<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * ColourTest.php 
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
require_once "PHP/Shell/Extensions/Colour.php";

/**
 * ColourTest 
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
class ColourTest extends PHPUnit_Framework_TestCase
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
                "colour"         => new PHP_Shell_Extensions_Colour(),
            )
        );
    }

    /**
     * testSetBackground 
     * 
     * @access public
     * @return void
     */
    public function testSetBackground()
    {
        // Check that enable the colour on valid enable string
        ob_start();
        $this->_shell_exts->colour->optSetBackground('colour', null);
        $this->assertEquals(
            ob_get_clean(),
            ":set colour needs a colour-scheme, e.g. :set colour=dark"
        );

        ob_start();
        $this->_shell_exts->colour->optSetBackground('colour', "notvalid");
        $this->assertEquals(
            ob_get_clean(),
            "setting colourscheme failed: colourscheme notvalid is unknown"
        );

        $this->_shell_exts->colour->optSetBackground('colour', "dark");
        $this->assertEquals("\033[1;33m", $this->_shell_exts->colour->getColour('default'));
        $this->assertEquals("\033[1;37m", $this->_shell_exts->colour->getColour('value'));
        $this->assertEquals("\033[0;35m", $this->_shell_exts->colour->getColour('exception'));
    }
}

