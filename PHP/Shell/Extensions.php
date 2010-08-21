<?php
/**
* Extension definition file
*
* PHP Version 5
*
* Extension can hook into the execution of the shell
*
* examples:
* - execution time for parsing and execute
* - colours for the output
* - inline help
*
* @category  Library
* @package   PHP_Shell
* @author    Jan Kneschke <jan@kneschke.de>
* @copyright 2006 Jan Kneschke
* @license   MIT <http://www.opensource.org/licenses/mit-license.php>
* @version   SVN: $Id$
* @link      http://pear.php.net/package/PHP_Shell
*/

/**
* the interface for all shell extensions 
*
* Extension can hook into the execution of the shell
*
* examples:
* - execution time for parsing and execute
* - colours for the output
* - inline help
*
* @category  Library
* @package   PHP_Shell
* @author    Jan Kneschke <jan@kneschke.de>
* @copyright 2006 Jan Kneschke
* @license   MIT <http://www.opensource.org/licenses/mit-license.php>
* @version   Release: @package_version@ 
* @link      http://pear.php.net/package/PHP_Shell
*  
*/
interface PHP_Shell_Extension
{
    /**
     * Register a extension
     * 
     * @access public
     * @return void
     */
    public function register();
}

/**
* storage class for Shell Extensions
*
* examples:
* - execution time for parsing and execute
* - colours for the output
* - inline help
*
* @category  Library
* @package   PHP_Shell
* @author    Jan Kneschke <jan@kneschke.de>
* @copyright 2006 Jan Kneschke
* @license   MIT <http://www.opensource.org/licenses/mit-license.php>
* @version   Release: @package_version@
* @link      http://pear.php.net/package/PHP_Shell
*
*/
class PHP_Shell_Extensions
{
    /**
     * @var PHP_Shell_Extensions
     */
    static protected $instance;

    /**
     * storage for the extension
     *
     * @var array
     */
    protected $exts = array();

    /**
     * the extension object gives access to the register objects
     * through the a simple $exts->name->...
     *
     * @param string $key registered name of the extension 
     *
     * @return PHP_Shell_Extension object handle
     */
    public function __get($key)
    {
        if (!isset($this->exts[$key])) {
            throw new Exception("Extension $s is not known.");
        }
        return $this->exts[$key];
    }

    /**
     * register set of extensions
     *
     * @param array $exts set of (name, class-name) pairs
     *
     * @return void
     */
    public function registerExtensions($exts)
    {
        foreach ($exts as $k => $v) {
            $this->registerExtension($k, $v);
        }
    }

    /**
     * register a single extension
     *
     * @param string              $k   name of the registered extension
     * @param PHP_Shell_Extension $obj the extension object
     *
     * @return void
     */
    public function registerExtension($k, PHP_Shell_Extension $obj)
    {
        $obj->register();

        $this->exts[$k] = $obj;
    }

    /**
     * Factory
     *
     * @return object a singleton of the class 
     */
    static function getInstance()
    {
        if (is_null(self::$instance)) {
            $class = __CLASS__;
            self::$instance = new $class();
        }
        return self::$instance;
    }
}


