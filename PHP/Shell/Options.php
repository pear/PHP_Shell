<?php
/**
* PHP_Shell_Options Extension implementation
*
* PHP Version 5
*
* This extension is a basic extension that provide the funcionality of set
* options to other extensions or to the whole PHP_Shell.
*
* @category  Extension
* @package   PHP_Shell
* @author    Jan Kneschke <jan@kneschke.de>
* @copyright 2006 Jan Kneschke
* @license   MIT <http://www.opensource.org/licenses/mit-license.php>
* @version   SVN: $Id$
* @link      http://pear.php.net/package/PHP_Shell
*
*/
require_once "PHP/Shell/Extensions.php"; /* for the PHP_Shell_Interface */
  
/**
* PHP_Shell_Options Class
*
* This class is a basic extension that provide the funcionality of set
* options to other extensions or to the whole PHP_Shell.
*
* @category  Extension
* @package   PHP_Shell
* @author    Jan Kneschke <jan@kneschke.de>
* @copyright 2006 Jan Kneschke
* @license   MIT <http://www.opensource.org/licenses/mit-license.php>
* @version   Release: @package_version@
* @link      http://pear.php.net/package/PHP_Shell
*
*/
class PHP_Shell_Options implements PHP_Shell_Extension
{
    /**
     * instance of the current class
     *
     * @var PHP_Shell_Options
     */
    static protected $instance;

    /**
     * known options and their setors
     *
     * @var array
     * @see registerOption
     */
    protected $options = array();

    /**
     * known options and their setors
     *
     * @var array
     * @see registerOptionAlias
     */
    protected $option_aliases = array();
 
    /**
     * Register
     *
     * @return void
     */
    public function register()
    {
        $cmd = PHP_Shell_Commands::getInstance();
        $cmd->registerCommand(
            '#^:set #',
            $this,
            'cmdSet',
            ':set <var>',
            'set a shell variable'
        );
    }

    /**
     * register a option
     *
     * @param string $option name of the option
     * @param object $obj    a object handle
     * @param string $setor  method-name of the setor in the object
     * @param string $getor  (unused)
     *
     * @return void
     */ 
    public function registerOption($option, $obj, $setor, $getor = null)
    {
        if (!is_callable(array($obj, $setor))) {
            $msg = sprintf(
                "setor %s doesn't exist on class %s",
                $setor, get_class($obj)
            );

            throw new Exception($msg);
        }

        $this->options[trim($option)] = array("obj" => $obj, "setor" => $setor);
    }

    /**
     * set a shell-var
     *
     * :set al to enable autoload
     * :set bg=dark to enable highlighting with a dark backgroud
     *
     * @param string $l Unknown
     *
     * @return void
     */
    public function cmdSet($l)
    {
        if (!preg_match('#:set\s+([a-z]+)\s*(?:=\s*([a-z0-9]+)\s*)?$#i', $l, $a)) {
            print(':set failed: either :set <option> or :set <option> = <value>');
            return;
        }

        $this->execute($a[1], isset($a[2]) ? $a[2] : null);
    }

    /**
     * get all the option names
     *
     * @return array names of all options
     */
    public function getOptions()
    {
        return array_keys($this->options);
    }

    /**
     * map a option to another option
     *
     * e.g.: bg maps to background
     *
     * @param string $alias  Alias (name)
     * @param string $option Option
     *
     * @return void
     */
    public function registerOptionAlias($alias, $option)
    {
        if (!isset($this->options[$option])) {
            throw new Exception(sprintf("Option %s is not known", $option));
        }

        $this->option_aliases[trim($alias)] = trim($option);
    
    }

    /**
     * execute a :set command
     *
     * calls the setor for the :set <option>
     * 
     * @param string $key   Key to set
     * @param mixed  $value Value to write
     *
     * @return void
     */
    protected function execute($key, $value)
    {
        /* did we hit a alias (bg for backgroud) ? */
        if (isset($this->option_aliases[$key])) {
            $opt_key = $this->option_aliases[$key];
        } else {
            $opt_key = $key;
        }

        if (!isset($this->options[$opt_key])) {
            print (':set '.$key.' failed: unknown key');
            return;
        }
        
        if (!isset($this->options[$opt_key]["setor"])) {
            return;
        }

        $setor = $this->options[$opt_key]["setor"];
        $obj = $this->options[$opt_key]["obj"];
        $obj->$setor($key, $value);
    }

    /**
     * Return an instance of this
     * 
     * @todo Remove this! Singletons are bad
     *
     * @return PHP_Shell_Options
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


