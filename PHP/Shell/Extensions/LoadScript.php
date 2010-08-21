<?php
/**
 * LoadScript.php LoadScript Extension
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
 * PHP_Shell_Extensions_LoadScript 
 * 
 * @category  Extension
 * @package   PHP_Shell
 * @author    Jan Kneschke <jan@kneschke.de>
 * @copyright 2006 Jan Kneschke
 * @license   MIT <http://www.opensource.org/licenses/mit-license.php>
 * @version   Release: @package_version@
 * @link      http://pear.php.net/package/PHP_Shell
 */
class PHP_Shell_Extensions_LoadScript implements PHP_Shell_Extension
{
    /**
     * register a extension
     * 
     * @access public
     * @return void
     */
    public function register()
    {
        $cmd = PHP_Shell_Commands::getInstance();

        $cmd->registerCommand(
            '#^r #',
            $this,
            'cmdLoadScript',
            'r <filename>', 
            'load a php-script and execute each line'
        );
    }

    /**
     * cmdLoadScript Load a script
     * 
     * @param string $l filename of the file to load
     *
     * @access public
     * @return void
     */
    public function cmdLoadScript($l)
    {
        $l = substr($l, 2);

        if (file_exists($l)) {
            $content = file($l);

            $source = array();

            foreach ($content as $line) {
                $line = chop($line);

                if (preg_match('#^<\?php#', $line)) {
                    continue;
                }

                $source[] = $line;
            }

            return $source;
        }
        return "";
    }
}
