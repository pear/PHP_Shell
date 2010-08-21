<?php
/**
 * Autoload.php Autoload Extension
 *
 * PHP version 5
 *
 * Note: shell wrapper has to create the __autoload() function when
 *       isAutoloadEnabled() is true
 *
 * handles the options to enable the internal autoload support
 *
 * :set al
 * :set autoload
 *
 * autoload can't be disabled
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
 * PHP_Shell_Extensions_Autoload 
 * 
 * @category  Extension
 * @package   PHP_Shell
 * @author    Jan Kneschke <jan@kneschke.de>
 * @copyright 2006 Jan Kneschke
 * @license   MIT <http://www.opensource.org/licenses/mit-license.php>
 * @version   Release: @package_version@
 * @link      http://pear.php.net/package/PHP_Shell
 */
class PHP_Shell_Extensions_Autoload implements PHP_Shell_Extension
{
    /**
     * does the use want to use the internal autoload ? 
     *
     * @var bool
     */
    protected $autoload = false;

    /**
     * register a extension
     * 
     * @access public
     * @return void
     */
    public function register()
    {
        $opt = PHP_Shell_Options::getInstance();

        $opt->registerOption("autoload", $this, "optSetAutoload");
        $opt->registerOptionAlias("al", "autoload");
    }

    /**
     * sets the autoload-flag
     *
     * - the $value is ignored and doesn't have to be set
     * - if __autoload() is defined, the set fails
     *
     * @param string $key   ignored
     * @param string $value ignored
     *
     * @return void
     */
    public function optSetAutoload($key, $value)
    {
        if ($this->autoload) {
            print('autoload is already enabled');
            return;
        }

        if (function_exists('__autoload')) {
            print(
                'can\'t enabled autoload as a external __autoload() function '.
                'is already defined'
            );
            return;
        }

        $this->autoload = true;
    }

    /**
     * is the autoload-flag set ?
     *
     * @return bool true if __autoload() should be set by the external wrapper
     */
    public function isAutoloadEnabled()
    {
        return $this->autoload;
    }
}

