<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * InlineHelpTest.php 
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
require_once "PHP/Shell/Extensions/InlineHelp.php";

// Global data to test
/**
 * TestClass
 *
 * @category  Test
 * @package   PHP_Shell
 * @author    Jesús Espino <jespinog@gmail.com>
 * @copyright 2010 Jesús Espino
 * @license   MIT <http://www.opensource.org/licenses/mit-license.php>
 * @version   Release: @package_version@
 * @link      http://pear.php.net/package/PHP_Shell
 */
class TestClass
{
    /**
     * property
     * 
     * @var float
     * @access public
     */
    static public $property = 3;

    /**
     * testMethod 
     * 
     * @access public
     * @return void
     */
    static public function testMethod() 
    {
        echo "hello world\n";
    }
}
$object = new TestClass();

/**
 * testFunction 
 * 
 * @access public
 * @return void
 */
function testFunction()
{
    echo "hello world\n";
}

/**
 * InlineHelpTest 
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
class InlineHelpTest extends PHPUnit_Framework_TestCase
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
                "options"        => PHP_Shell_Options::getInstance(), /* the :set command */
                "inlinehelp"     => new PHP_Shell_Extensions_InlineHelp(),
            )
        );
    }

    /**
     * testCmdHelpClass 
     * 
     * @access public
     * @return void
     */
    public function testCmdHelpClass()
    {
        $this->assertEquals(
            '\'no help found for \\\'NotFoundClass\\\'\'',
            $this->_shell_exts->inlinehelp->cmdHelp('? NotFoundClass')
        );
        $this->assertEquals(
            '\'no help found for \\\'PHP_Shell_Extension::not_found_property\\\'\'',
            $this->_shell_exts->inlinehelp->cmdHelp('? PHP_Shell_Extension::not_found_property')
        );
        $this->assertEquals(
            '\'no help found for \\\'PHP_Shell_Extension::notFoundMethod()\\\'\'',
            $this->_shell_exts->inlinehelp->cmdHelp('? PHP_Shell_Extension::notFoundMethod()')
        );

        $test_class_help = <<<EOT
'/**
 * TestClass
 *
 * @category  Test
 * @package   PHP_Shell
 * @author    Jesús Espino <jespinog@gmail.com>
 * @copyright 2010 Jesús Espino
 * @license   MIT <http://www.opensource.org/licenses/mit-license.php>
 * @version   Release: @package_version@
 * @link      http://pear.php.net/package/PHP_Shell
 */'
EOT;
        $this->assertEquals(
            $test_class_help,
            $this->_shell_exts->inlinehelp->cmdHelp('? TestClass')
        );

        $test_class_method_help = <<<EOT
'/**
     * testMethod 
     * 
     * @access public
     * @return void
     */'
EOT;
        $this->assertEquals(
            $test_class_method_help,
            $this->_shell_exts->inlinehelp->cmdHelp('? TestClass::testMethod()')
        );

        $test_class_property_help = <<<EOT
'/**
     * property
     * 
     * @var float
     * @access public
     */'
EOT;
        $this->assertEquals(
            $test_class_property_help,
            $this->_shell_exts->inlinehelp->cmdHelp('? TestClass::property')
        );
    }

    /**
     * testCmdHelpInstance 
     * 
     * @access public
     * @return void
     */
    public function testCmdHelpInstance()
    {
        $this->assertEquals(
            '\'no help found for \\\'$not_found_instance\\\'\'',
            $this->_shell_exts->inlinehelp->cmdHelp('? $not_found_instance')
        );
        $this->assertEquals(
            '\'no help found for \\\'$instance->not_found_property\\\'\'',
            $this->_shell_exts->inlinehelp->cmdHelp('? $instance->not_found_property')
        );
        $this->assertEquals(
            '\'no help found for \\\'$instance->notFoundMethod\\\'\'',
            $this->_shell_exts->inlinehelp->cmdHelp('? $instance->notFoundMethod')
        );

        $object_help = <<<EOT
'/**
 * TestClass
 *
 * @category  Test
 * @package   PHP_Shell
 * @author    Jesús Espino <jespinog@gmail.com>
 * @copyright 2010 Jesús Espino
 * @license   MIT <http://www.opensource.org/licenses/mit-license.php>
 * @version   Release: @package_version@
 * @link      http://pear.php.net/package/PHP_Shell
 */'
EOT;
        $this->assertEquals(
            $object_help,
            $this->_shell_exts->inlinehelp->cmdHelp('? $object')
        );

        $test_object_method_help = <<<EOT
'/**
     * testMethod 
     * 
     * @access public
     * @return void
     */'
EOT;
        $this->assertEquals(
            $test_object_method_help,
            $this->_shell_exts->inlinehelp->cmdHelp('? $object->testMethod()')
        );

        $test_object_property_help = <<<EOT
'/**
     * property
     * 
     * @var float
     * @access public
     */'
EOT;
        $this->assertEquals(
            $test_object_property_help,
            $this->_shell_exts->inlinehelp->cmdHelp('? $object->property')
        );
    }

    /**
     * testCmdHelpPrototype 
     * 
     * @access public
     * @return void
     */
    public function testCmdHelpPrototype()
    {
        $exception__toString_help = <<<EOT
'/**
* Obtain the string representation of the Exception object

* @params 
* @return string
*/
'
EOT;
        $this->assertEquals(
            $exception__toString_help,
            $this->_shell_exts->inlinehelp->cmdHelp('? Exception::__toString()')
        );
    }

    /**
     * testCmdHelpPrototype 
     * 
     * @access public
     * @return void
     */
    public function testCmdHelpFunction()
    {
        $this->assertEquals(
            '\'no help found for \\\'notExistFunction()\\\'\'',
            $this->_shell_exts->inlinehelp->cmdHelp('? notExistFunction()')
        );
        $function_help = <<<EOT
'/**
 * testFunction 
 * 
 * @access public
 * @return void
 */'
EOT;
        $this->assertEquals(
            $function_help,
            $this->_shell_exts->inlinehelp->cmdHelp('? testFunction()')
        );
    }
}
