<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * OptionsTest.php 
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
 * OptionsTest 
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
class OptionsTest extends PHPUnit_Framework_TestCase
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
                "options" => PHP_Shell_Options::getInstance(), /* the :set command */
            )
        );
    }

    /**
     * testRegisterOption 
     * 
     * @access public
     * @return void
     */
    public function testRegisterOption()
    {
        $this->_shell_exts->options->registerOption(
            'registerOptionTest',
            new PHP_Shell_Extensions_Echo(),
            'optSetEcho'
        );
        $options = $this->_shell_exts->options->getOptions();
        $this->assertTrue(in_array('registerOptionTest', $options));
        
        try {
            $this->_shell_exts->options->registerOption(
                'bad_option',
                null,
                'BadMethod'
            );
        } catch (Exception $e) {
            $this->assertEquals(
                $e->getMessage(),
                "setor BadMethod doesn't exist on class PHP_Shell_Options"
            );
        }

    }

    /**
     * testCmdSet 
     * 
     * @access public
     * @return void
     */
    public function testCmdSet()
    {
        $this->_shell_exts->options->registerOption(
            'echo',
            new PHP_Shell_Extensions_Echo(),
            'optSetEcho'
        );
        $this->_shell_exts->options->registerOptionAlias('aliasecho', 'echo');

        ob_start();
        $this->_shell_exts->options->cmdSet(":set 10");
        $this->assertEquals(
            ob_get_clean(),
            ":set failed: either :set <option> or :set <option> = <value>"
        );
        ob_start();
        $this->_shell_exts->options->cmdSet(":set echo=true");
        $this->assertEquals(
            ob_get_clean(),
            ""
        );
        ob_start();
        $this->_shell_exts->options->cmdSet(":set aliasecho=true");
        $this->assertEquals(
            ob_get_clean(),
            ""
        );
        ob_start();
        $this->_shell_exts->options->cmdSet(":set noexists=true");
        $this->assertEquals(
            ob_get_clean(),
            ":set noexists failed: unknown key"
        );
    }

    /**
     * testGetOptions 
     * 
     * @access public
     * @return void
     */
    public function testGetOptions()
    {
        $this->_shell_exts->options->registerOption(
            'getOptionsTest',
            new PHP_Shell_Extensions_Echo(),
            'optSetEcho'
        );
        $options = $this->_shell_exts->options->getOptions();
        $this->assertTrue(in_array('getOptionsTest', $options));
    }

    /**
     * testRegisterOptionAlias 
     * 
     * @access public
     * @return void
     */
    public function testRegisterOptionAlias()
    {
        $this->_shell_exts->options->registerOption(
            'echo',
            new PHP_Shell_Extensions_Echo(),
            'optSetEcho'
        );
        $this->_shell_exts->options->registerOptionAlias('aliasecho', 'echo');
        try {
            $this->_shell_exts->options->registerOptionAlias(
                'aliasnotexists',
                'notexists'
            );
        } catch (Exception $e) {
            $this->assertEquals($e->getMessage(), "Option notexists is not known");
        }
    }
}
?>
