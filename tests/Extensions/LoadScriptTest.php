<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * LoadScriptTest.php
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
require_once "PHP/Shell/Extensions/LoadScript.php";

/**
 * LoadScriptTest
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
class LoadScriptTest extends PHPUnit_Framework_TestCase
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
                "loadscript"           => new PHP_Shell_Extensions_LoadScript(),
            )
        );
    }

    /**
     * testCmdLoadScript
     *
     * @access public
     * @return void
     */
    public function testCmdLoadScript()
    {
        $expected = file_get_contents(__FILE__);
        $expected = substr($expected, 6);
        $result = $this->_shell_exts->loadscript->cmdLoadScript("r ".__FILE__);
        $this->assertEquals($expected, implode("\n", $result)."\n");

        $result = $this->_shell_exts->loadscript->cmdLoadScript("r file-that-not-exists");
        $this->assertEquals("", $result);
    }
}
