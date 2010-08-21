<?php
/**
 * VerbosePrint.php VerbosePrint Extension
 *
 * PHP version 5
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
 * PHP_Shell_Extensions_VerbosePrint 
 * 
 * @category  Extension
 * @package   PHP_Shell
 * @author    Jan Kneschke <jan@kneschke.de>
 * @copyright 2006 Jan Kneschke
 * @license   MIT <http://www.opensource.org/licenses/mit-license.php>
 * @version   Release: @package_version@
 * @link      http://pear.php.net/package/PHP_Shell
 */
class PHP_Shell_Extensions_VerbosePrint implements PHP_Shell_Extension
{
    protected $opt_verbose = false;
    protected $oneshot_verbose = false;

    /**
     * Register a command
     * 
     * @return void
     */
    public function register()
    {
        $cmd = PHP_Shell_Commands::getInstance();
        $cmd->registerCommand(
            '#^p #',
            $this,
            'cmdPrint',
            'p <var>',
            'print the variable verbosly'
        );

        $opt = PHP_Shell_Options::getInstance();
        $opt->registerOption('verboseprint', $this, 'optSetVerbose');

    }

    /**
     * handle the 'p ' command
     *
     * set the verbose flag
     *
     * @param string $l Line
     *
     * @return string the pure command-string without the 'p ' command
     */
    public function cmdPrint($l)
    {
        $this->oneshot_verbose = true;

        $cmd = substr($l, 2);

        return $cmd;
    }

    /**
     * Set verbose
     *
     * @param string $key   Unused
     * @param string $value One of 'false', 'on', etc
     *
     * @return void
     */
    public function optSetVerbose($key, $value)
    {
        switch($value) {
        case "true":
        case "on":
        case "1":
            $this->opt_verbose = true;
            break;
        default:
            $this->opt_verbose = false;
            break;
        }
    }

    /**
     * check if we have a verbose print-out
     *
     * @return bool 1 if verbose, 0 otherwise
     */
    public function isVerbose()
    {
        $v = $this->opt_verbose || $this->oneshot_verbose;

        $this->oneshot_verbose = false;
        
        return $v;
    }
}


