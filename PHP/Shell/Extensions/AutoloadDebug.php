<?php
/**
* Autoload debugging
*
* PHP Version 5
*
* The internal __autoload() function of the shell-wrapper has two hooks.
* The first is called before the include is done, the second afterwards.
*
* we use it to track the order the includes are handled. That makes it 
* easier to find implicit dependency problems.
*
* :set autoloaddebug = on
* :set autoloaddebug = off
*
* the depth functions track the recursive depth of the includes. The
* wrapper uses it to print the dots at the beginning of the line.
*
* @category  Extension
* @package   PHP_Shell
* @author    Jan Kneschke <jan@kneschke.de>
* @copyright 2006 Jan Kneschke
* @license   MIT <http://www.opensource.org/licenses/mit-license.php>
* @version   SVN: $Id$
* @link      http://pear.php.net/package/PHP_Shell
*/

/**
 * PHP_Shell_Extensions_AutoloadDebug
 * 
 * @category  Extension
 * @package   PHP_Shell
 * @author    Jan Kneschke <jan@kneschke.de>
 * @copyright 2006 Jan Kneschke
 * @license   MIT <http://www.opensource.org/licenses/mit-license.php>
 * @version   Release: @package_version@
 * @link      http://pear.php.net/package/PHP_Shell
 */
class PHP_Shell_Extensions_AutoloadDebug implements PHP_Shell_Extension
{
    /**
     * is the extenion enabled
     *
     * @var bool
     */
    protected $autoload_debug = false;

    /**
     * recursive depth of the includes
     *
     * @var int
     */
    protected $autoload_depth = 0;

    /**
     * register a extension
     * 
     * @access public
     * @return void
     */
    public function register()
    {
        $opt = PHP_Shell_Options::getInstance();
        $opt->registerOption('autoloaddebug', $this, 'optSetAutoloadDebug');
    }

    /**
     * handle the autoloaddebug flag
     *
     * @param string $key   the config name
     * @param string $value the value to set
     *
     * @return void 
     */
    public function optSetAutoloadDebug($key, $value)
    {
        switch ($value) {
        case "enable":
        case "1":
        case "on":
            $this->autoload_debug = true;
            break;
        case "disable":
        case "0":
        case "off":
            $this->autoload_debug = false;
            break;
        default:
            printf(
                ":set %s failed, unknown value. Use :set %s = (on|off)",
                $key,
                $key
            );
            return;
        }

    }

    /**
     * is the autoload-debug flag set ?
     *
     * @return bool true if debug is enabled
     */
    public function isAutoloadDebug()
    {
        return $this->autoload_debug;
    }

    /**
     * increment the depth counter
     *
     * @return int
     */
    public function incAutoloadDepth()
    {
        return $this->autoload_depth++;
    }
    
    /**
     * decrement the depth counter
     *
     * @return int
     */
    public function decAutoloadDepth()
    {
        return --$this->autoload_depth;
    }
}

