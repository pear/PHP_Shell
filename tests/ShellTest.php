<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * ShellTest.php 
 *
 * PHP Version 5
 * 
 * @category  Test
 * @package   PHP_Shell
 * @author    Jan Kneschke <jan@kneschke.de>
 * @copyright 2006 Jan Kneschke
 * @license   MIT <http://www.opensource.org/licenses/mit-license.php>
 * @version   SVN: $Id$
 * @link      http://pear.php.net/package/PHP_Shell
 */


require_once 'PHP/Shell.php';

/**
 * ShellTest 
 * 
 * @uses      PHPUnit_Framework_TestCase
 * @category  Test
 * @package   PHP_Shell
 * @author    Jan Kneschke <jan@kneschke.de>
 * @copyright 2006 Jan Kneschke
 * @license   MIT <http://www.opensource.org/licenses/mit-license.php>
 * @version   Release: @package_version@
 * @link      http://pear.php.net/package/PHP_Shell
 */
class ShellTest extends PHPUnit_Framework_TestCase
{
    private $_vars;

    /**
     * setUp 
     * 
     * @access public
     * @return void
     */
    public function setUp()
    {
        /* create a fresh shell object */

        $this->shell = new PHP_Shell();

        $this->_vars = array();
    }

    /**
     * tearDown 
     * 
     * @access public
     * @return void
     */
    public function tearDown()
    {
        foreach ($this->_vars as $k => $v) {
            unset($GLOBALS[$k]);
        }
    }

    /**
     * execute 
     * 
     * @access public
     * @return void
     */
    public function execute()
    {
        $__retval = null;

        // get local vars
        foreach ($this->_vars as $__k => $__v) {
            ${$__k} = $GLOBALS[$__k];
        }
        unset($__k);
        unset($__v);
        
        if ($this->shell->parse() == 0) {
            $__retval = eval($this->shell->getCode()); 

            // export vars to global scope
            foreach (
                array_diff_key(
                    get_defined_vars(),
                    $GLOBALS,
                    array("__retval" => 1)
                ) as $__k => $__v
            ) {
                $GLOBALS[$__k] = $__v;
                $this->_vars[$__k] = $__v;
            }
        }

        return $__retval;
    }

    /**
     * testComments 
     * 
     * @access public
     * @return void
     */
    public function testComments()
    {
        $tests = array(
            '## comment',
            '/* comment */',
            '// comment'
            );
        foreach ($tests as $code) {
            $this->shell->resetCode();
            $this->shell->appendCode($code);

            if ($this->shell->parse() == 0) {
                eval($this->shell->getCode()); 
            }
        }
    }

    /**
     * testUndefVars 
     * 
     * @access public
     * @return void
     */
    public function testUndefVars()
    {
        $tests = array(
            '$v',
            );
        foreach ($tests as $code) {
            $this->shell->resetCode();
            $this->shell->appendCode($code);

            // we should get a Exception
            try {
                $this->execute();
                $this->fail();
            } catch ( Exception $e ) {
            }
        }
    }

    /**
     * testNewClass 
     * 
     * @access public
     * @return void
     */
    public function testNewClass()
    {
        $tests = array(
            '$v = new ArrayObject()',
            );
        foreach ($tests as $code) {
            $this->shell->resetCode();
            $this->shell->appendCode($code);
            $this->execute();
        }
    }

    /**
     * testMethod 
     * 
     * @access public
     * @return void
     */
    public function testMethod()
    {
        $tests = array(
            '$v = new ArrayObject()',
            '$v->count()'
            );
        foreach ($tests as $code) {
            $this->shell->resetCode();
            $this->shell->appendCode($code);
            $this->execute();
        }
    }

    /**
     * testNotExistingMethod 
     * 
     * @access public
     * @return void
     */
    public function testNotExistingMethod()
    {
        $tests = array(
            '$v = new ArrayObject()',
            '$v->not_existing()'
            );
        foreach ($tests as $code) {
            $this->shell->resetCode();
            $this->shell->appendCode($code);

            // we should get a Exception
            try {
                $this->execute();
                $this->fail();
            } catch ( Exception $e ) {
            }
        }
    }

    /**
     * testNotExistingClass 
     * 
     * @access public
     * @return void
     */
    public function testNotExistingClass()
    {
        $tests = array(
            '$not_existing->not_existing()'
            );
        foreach ($tests as $code) {
            $this->shell->resetCode();
            $this->shell->appendCode($code);

            // we should get a Exception
            try {
                $this->execute();
                $this->fail();
            } catch ( Exception $e ) {
            }
        }
    }

    /**
     * testClass 
     * 
     * @access public
     * @return void
     */
    public function testClass()
    {
        $tests = array(
            'class a { const a = "a"; }'
            );
        foreach ($tests as $code) {
            $this->shell->resetCode();
            $this->shell->appendCode($code);

            // we should get a Exception
            $this->execute();
        }
    }

    /**
     * testClassExtends 
     * 
     * @access public
     * @return void
     */
    public function testClassExtends()
    {
        $tests = array(
            'class b extends a { }',
            );
        foreach ($tests as $code) {
            $this->shell->resetCode();
            $this->shell->appendCode($code);

            // we should get a Exception
            $this->execute();
        }
    }

    /**
     * testClassExtendsNotExisting 
     * 
     * @access public
     * @return void
     */
    public function testClassExtendsNotExisting()
    {
        $tests = array(
            'class c extends not_existing { }',
            );
        foreach ($tests as $code) {
            $this->shell->resetCode();
            $this->shell->appendCode($code);

            // we should get a Exception
            try {
                $this->execute();
                $this->fail();
            } catch ( Exception $e ) {
            }
        }
    }

    /**
     * testClassDuplicate 
     * 
     * @access public
     * @return void
     */
    public function testClassDuplicate()
    {
        $tests = array(
            'class duplicate_class { }',
            'class duplicate_class { }',
            );
        foreach ($tests as $code) {
            $this->shell->resetCode();
            $this->shell->appendCode($code);

            // we should get a Exception
            try {
                $this->execute(); 
                $this->fail();
            } catch ( Exception $e ) {
            }
        }
    }

    /**
     * testClassDuplicateMethod 
     * 
     * @access public
     * @return void
     */
    public function testClassDuplicateMethod()
    {
        $tests = array(
            'class d { function duplicate_method () { } '.
            'function duplicate_method() {} }',
            );
        foreach ($tests as $code) {
            $this->shell->resetCode();
            $this->shell->appendCode($code);

            // we should get a Exception
            try {
                $this->execute();
                $this->fail();
            } catch ( Exception $e ) {
            }
        }
    }

    /**
     * testClassConstant 
     * 
     * @access public
     * @return void
     */
    public function testClassConstant()
    {
        $tests = array(
            'a::a',
            );
        foreach ($tests as $code) {
            $this->shell->resetCode();
            $this->shell->appendCode($code);

            $this->execute();
        }
    }

    /**
     * testClassConstantNotExisting 
     * 
     * @access public
     * @return void
     */
    public function testClassConstantNotExisting()
    {
        $tests = array(
            'a::not_existing',
            );
        foreach ($tests as $code) {
            $this->shell->resetCode();
            $this->shell->appendCode($code);

            // we should get a Exception
            try {
                $this->execute();
                $this->fail();
            } catch ( Exception $e ) {
            }
        }
    }

    /**
     * testFunctionDuplicate 
     * 
     * @access public
     * @return void
     */
    public function testFunctionDuplicate()
    {
        $tests = array(
            'function duplicate_function() {}',
            'function duplicate_function() {}',
            );
        foreach ($tests as $code) {
            $this->shell->resetCode();
            $this->shell->appendCode($code);

            // we should get a Exception
            try {
                $this->execute();
                $this->fail();
            } catch ( Exception $e ) {
            }
        }
    }

    /**
     * testFunctionDynamicNotExisting 
     * 
     * @access public
     * @return void
     */
    public function testFunctionDynamicNotExisting()
    {
        $tests = array(
            '$v = "vfunc"',
            '$v()',
            );
        foreach ($tests as $code) {
            $this->shell->resetCode();
            $this->shell->appendCode($code);

            // we should get a Exception
            try {
                $this->execute();
                $this->fail();
            } catch ( Exception $e ) {
            }
        }
    }

    /**
     * testLoops 
     * 
     * @access public
     * @return void
     */
    public function testLoops()
    {
        $tests = array(
            '$a = array(0 => "2", 1 => "3")',
            'foreach ($a as $k => $v) { }',
            'do {} while(0)',
            'while(0) {}',
            'for ($i = 0; $i < count($a); $i++) {} '
            );
        foreach ($tests as $code) {
            $this->shell->resetCode();
            $this->shell->appendCode($code);

            $this->execute();
        }
    }

    /**
     * testIf 
     * 
     * @access public
     * @return void
     */
    public function testIf()
    {
        $tests = array(
            'if (0) { } else if (1) { } else { } ',
            );
        foreach ($tests as $code) {
            $this->shell->resetCode();
            $this->shell->appendCode($code);

            $this->execute();
        }
    }

    /**
     * testImplements 
     * 
     * @access public
     * @return void
     */
    public function testImplements()
    {
        $tests = array(
            'class e implements Serializable { '.
            'function serialize() { } '.
            'function unserialize($a) {} '.
            '}',
            );
        foreach ($tests as $code) {
            $this->shell->resetCode();
            $this->shell->appendCode($code);

            $this->execute();
        }
    }

    /**
     * testInterfaceNotExists 
     * 
     * @access public
     * @return void
     */
    public function testInterfaceNotExists()
    {
        $tests = array(
            'class f implements not_existing_interface { }',
            );
        foreach ($tests as $code) {
            $this->shell->resetCode();
            $this->shell->appendCode($code);

            // we should get a Exception
            try { 
                $this->execute();
                $this->fail(); 
            } catch ( Exception $e ) {
            }
        }
    }

    /**
     * testAbstractClass 
     * 
     * @access public
     * @return void
     */
    public function testAbstractClass()
    {
        $tests = array(
            'abstract class g { abstract function f(); }',
            '$f = new g()',
            );
        foreach ($tests as $code) {
            $this->shell->resetCode();
            $this->shell->appendCode($code);

            // we should get a Exception
            try {
                $this->execute();
                $this->fail();
            } catch ( Exception $e ) {
            }
        }
    }

    /**
     * testStaticCall 
     * 
     * @access public
     * @return void
     */
    public function testStaticCall()
    {
        $tests = array(
            'class h { static function foo() { } }',
            'h::foo()'
            );
        foreach ($tests as $code) {
            $this->shell->resetCode();
            $this->shell->appendCode($code);

            $this->execute();
        }
    }

    /**
     * testStaticCallNotExists 
     * 
     * @access public
     * @return void
     */
    public function testStaticCallNotExists()
    {
        $tests = array(
            'h::not_exists()'
            );
        foreach ($tests as $code) {
            $this->shell->resetCode();
            $this->shell->appendCode($code);

            // we should get a Exception
            try {
                $this->execute();
                $this->fail();
            } catch ( Exception $e ) {
            }
        }
    }

    /**
     * testObjectArray 
     * 
     * @access public
     * @return void
     */
    public function testObjectArray()
    {
        $tests = array(
            'class obj_array { static function params($p1, $p2) { } }',
            '$c = new ReflectionClass("obj_array")',
            '$m = $c->getMethods()',
            '$m[0]->getParameters()'
            );
        foreach ($tests as $code) {
            $this->shell->resetCode();
            $this->shell->appendCode($code);

            $this->execute();
        }
    }

    /**
     * testObjectArrayMethodNotExists 
     * 
     * @access public
     * @return void
     */
    public function testObjectArrayMethodNotExists()
    {
        $tests = array(
            '$c = new ReflectionClass("obj_array")',
            '$m = $c->getMethods()',
            '$m[0]->getPrototyp()'
            );
        foreach ($tests as $code) {
            $this->shell->resetCode();
            $this->shell->appendCode($code);

            // we should get a Exception
            try {
                $this->execute(); 
                $this->fail();
            } catch ( Exception $e ) {
            }
        }
    }

    /**
     * testVariableMethod 
     * 
     * @access public
     * @return void
     */
    public function testVariableMethod()
    {
        $tests = array(
            '$c = new obj_array()',
            '$m = "params"',
            '$c->$m(1, 2)'
            );
        foreach ($tests as $code) {
            $this->shell->resetCode();
            $this->shell->appendCode($code);

            $this->execute();
        }
    }

    /**
     * testVariableStaticMethod 
     * 
     * @access public
     * @return void
     */
    public function testVariableStaticMethod()
    {
        $tests = array(
            '$m = "params"',
            'obj_array::$m(1, 2)'
            );
        foreach ($tests as $code) {
            $this->shell->resetCode();
            $this->shell->appendCode($code);

            $this->execute();
        }
    }

    /**
     * testVariableMethodNotExisting 
     * 
     * @access public
     * @return void
     */
    public function testVariableMethodNotExisting()
    {
        $tests = array(
            '$c = new obj_array()',
            '$m = "foo"',
            '$c->$m(1, 2)'
            );
        foreach ($tests as $code) {
            $this->shell->resetCode();
            $this->shell->appendCode($code);

            // we should get a Exception
            try {
                $this->execute();
                $this->fail();
            } catch ( Exception $e ) {
            }
        }
    }

    /**
     * testInternalMethodCall 
     * 
     * @access public
     * @return void
     */
    public function testInternalMethodCall()
    {
        $tests = array(
            'class thisclass { function a() { } function b () { $this->a(); }}',
            );
        foreach ($tests as $code) {
            $this->shell->resetCode();
            $this->shell->appendCode($code);

            $this->execute();
        }
    }

    /**
     * testSingletonClass 
     * 
     * @access public
     * @return void
     */
    public function testSingletonClass()
    {
        $tests = array(
            'class singleton { '.
            '  static private $inst = null; '.
            '  static function getInstance() { '.
            '    if (is_null(self::$inst)) { '.
            '       self::$inst = new singleton(); '.
            '    } '.
            '    return self::$inst; '.
            '  } '.
            '  public function get() { return 1; }'.
            '}',
            );
        foreach ($tests as $code) {
            $this->shell->resetCode();
            $this->shell->appendCode($code);

            $this->execute();
        }
    }

    /**
     * testGetInstance 
     * 
     * @access public
     * @return void
     */
    public function testGetInstance()
    {
        $tests = array(
            'singleton::getInstance()->get()'
            );
        foreach ($tests as $code) {
            $this->shell->resetCode();
            $this->shell->appendCode($code);

            $this->execute();
        }
    }

    /**
     * testArrayAccessOnObject 
     * 
     * @access public
     * @return void
     */
    public function testArrayAccessOnObject()
    {
        $tests = array(
            '$a = new stdClass()',
            '$a[0]'
            );
        foreach ($tests as $code) {
            $this->shell->resetCode();
            $this->shell->appendCode($code);

            // we should get a Exception
            try {
                $this->execute();
                $this->fail();
            } catch ( Exception $e ) {
            }
        }
    }

    /**
     * testFunctionVars 
     * 
     * @access public
     * @return void
     */
    public function testFunctionVars()
    {
        $tests = array(
            'function '.__FUNCTION__.'($a) { print $a; }'
            );
        foreach ($tests as $code) {
            $this->shell->resetCode();
            $this->shell->appendCode($code);

            $this->execute();
        }
    }

    /**
     * testMethodVars 
     * 
     * @access public
     * @return void
     */
    public function testMethodVars()
    {
        $tests = array(
            'class '.__FUNCTION__.' { function f2($a) { print $a; } }'
            );
        foreach ($tests as $code) {
            $this->shell->resetCode();
            $this->shell->appendCode($code);

            $this->execute();
        }
    }

    /**
     * testMethodDynamicConst 
     * 
     * @access public
     * @return void
     */
    public function testMethodDynamicConst()
    {
        $tests = array(
            'class '.__FUNCTION__.' { function f2($a) { print $a->foo; } }'
            );
        foreach ($tests as $code) {
            $this->shell->resetCode();
            $this->shell->appendCode($code);

            $this->execute();
        }
    }

    /**
     * testMethodDynamicFunction 
     * 
     * @access public
     * @return void
     */
    public function testMethodDynamicFunction()
    {
        $tests = array(
            'class '.__FUNCTION__.' { function f2($a) { print $a->foo(); } }'
            );
        foreach ($tests as $code) {
            $this->shell->resetCode();
            $this->shell->appendCode($code);

            $this->execute();
        }
    }
    /**
     * testMethodDynamicFunctionDynamic 
     * 
     * @access public
     * @return void
     */
    public function testMethodDynamicFunctionDynamic()
    {
        $tests = array(
            'class '.__FUNCTION__.' { function f2($a) { print $a->$foo(); } }'
            );
        foreach ($tests as $code) {
            $this->shell->resetCode();
            $this->shell->appendCode($code);

            $this->execute();
        }
    }

    /**
     * testGetVersion 
     * 
     * @access public
     * @return void
     */
    public function testGetVersion()
    {
        $version = $this->shell->getVersion();
        $this->assertEquals('0.3.1', $version);
    }

    /**
     * testHasReadline 
     * 
     * @access public
     * @return void
     */
    public function testHasReadline()
    {
        $have_readline = $this->shell->hasReadline();
        $this->assertEquals(function_exists('readline'), $have_readline);
    }

    /**
     * testReadLine 
     * 
     * @access public
     * @return void
     */
    public function testReadLine()
    {
        // ToDo: Try to create a better test for readline function
        $all_completions = PHP_Shell_readlineComplete("", 0);
        $this->assertTrue(in_array("Exception::", $all_completions));
        $this->assertTrue(in_array("printf(", $all_completions));
    }

    /**
     * testCmdLicense 
     * 
     * @access public
     * @return void
     */
    public function testCmdLicense()
    {
        $line = "Not important, not used";
        $expected = <<< EOT
'(c) 2006 Jan Kneschke <jan@kneschke.de>

Permission is hereby granted, free of charge, to any person obtaining a copy of
this software and associated documentation files (the "Software"), to deal in
the Software without restriction, including without limitation the rights to
use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies
of the Software, and to permit persons to whom the Software is furnished to do
so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.'
EOT;
        $license = $this->shell->cmdLicense($line);
        $this->assertEquals($license, $expected);
    }


}
