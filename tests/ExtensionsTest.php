<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * ExtensionsTest.php 
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
require_once "PHP/Shell/Extensions/AutoloadDebug.php";
require_once "PHP/Shell/Extensions/Colour.php";
require_once "PHP/Shell/Extensions/ExecutionTime.php";
require_once "PHP/Shell/Extensions/InlineHelp.php";
require_once "PHP/Shell/Extensions/VerbosePrint.php";
require_once "PHP/Shell/Extensions/LoadScript.php";
require_once "PHP/Shell/Extensions/Echo.php";

/**
 * ExtensionsTest 
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
class ExtensionsTest extends PHPUnit_Framework_TestCase
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
    }

    /**
     * testRegisterExtensions 
     * 
     * @access public
     * @return void
     */
    public function testRegisterExtensions()
    {
        $this->_shell_exts->registerExtensions(
            array(
                "options"        => PHP_Shell_Options::getInstance(), /* the :set command */
                "autoload"       => new PHP_Shell_Extensions_Autoload(),
                "autoload_debug" => new PHP_Shell_Extensions_AutoloadDebug(),
                "colour"         => new PHP_Shell_Extensions_Colour(),
                "exectime"       => new PHP_Shell_Extensions_ExecutionTime(),
                "inlinehelp"     => new PHP_Shell_Extensions_InlineHelp(),
                "verboseprint"   => new PHP_Shell_Extensions_VerbosePrint(),
                "loadscript"     => new PHP_Shell_Extensions_LoadScript(),
                "echo"           => new PHP_Shell_Extensions_Echo(),
            )
        );
    }
}

