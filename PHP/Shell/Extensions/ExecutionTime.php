<?php
/**
 * ExecutionTime.php ExecutionTime Extension
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
 * PHP_Shell_Extensions_ExecutionTime 
 * 
 * @category  Extension
 * @package   PHP_Shell
 * @author    Jan Kneschke <jan@kneschke.de>
 * @copyright 2006 Jan Kneschke
 * @license   MIT <http://www.opensource.org/licenses/mit-license.php>
 * @version   Release: @package_version@
 * @link      http://pear.php.net/package/PHP_Shell
 */
class PHP_Shell_Extensions_ExecutionTime implements PHP_Shell_Extension
{
    protected $show_exectime = false;

    protected $parse_time;
    protected $exec_time;
    protected $end_time;

    /**
     * register a function
     * 
     * @access public
     * @return void
     */
    public function register()
    {
        $opt = PHP_Shell_Options::getInstance();

        $opt->registerOption("exectime", $this, "optSetExecTime");
    }

    /**
     * optSetExecTime 
     * 
     * @param mixed $key the config name
     * @param mixed $val the value to set
     *
     * @access public
     * @return void
     */
    public function optSetExecTime($key, $val)
    {
        switch ($val) {
        case "enable":
        case "1":
        case "on":
            $this->show_exectime = true;
            break;
        case "disable":
        case "0":
        case "off":
            $this->show_exectime = false;
            break;
        default:
            printf(
                ":set %s failed, unknown value. Use :set %s = (on|off)",
                $key,
                $key
            );
            break;
        }
    }

    /**
     * startParseTime Set the parser start time to now
     * 
     * @access public
     * @return void
     */
    public function startParseTime()
    {
        $this->parse_time = microtime(1);
        $this->exec_time = 0.0;
    }

    /**
     * startExecTime Set the start exec time to now
     * 
     * @access public
     * @return void
     */
    public function startExecTime()
    {
        $this->exec_time = microtime(1);
    }
    /**
     * stopTime Set the end time to now
     * 
     * @access public
     * @return void
     */
    public function stopTime()
    {
        $this->end_time = microtime(1);
    }

    /**
     * getParseTime return the parser consumed time
     * 
     * @access public
     * @return float
     */
    public function getParseTime()
    {
        return ($this->exec_time == 0.0 ? $this->end_time : $this->exec_time) - $this->parse_time;
    }
 
    /**
     * getExecTime return the exec consumed time
     * 
     * @access public
     * @return float
     */
    public function getExecTime()
    {
        return ($this->exec_time == 0.0 ? 0.0 : $this->end_time - $this->exec_time);
    }
   
    /**
     * is the ExecTime extension enabled?
     * 
     * @access public
     * @return boolean
     */
    public function isShow()
    {
        return $this->show_exectime;
    }
}
