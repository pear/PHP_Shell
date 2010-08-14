<?php
class PHP_Shell_Extensions_Echo implements PHP_Shell_Extension
{
    protected $opt_echo = true;

    /**
     * Register a command
     * 
     * @return void
     */
    public function register()
    {
        $opt = PHP_Shell_Options::getInstance();
        $opt->registerOption('echo', $this, 'optSetEcho');
    }

    /**
     * Set verbose
     *
     * @param string $key   Unused
     * @param string $value One of 'false', 'on', etc
     *
     * @return void
     */
    public function optSetEcho($key, $value)
    {
        switch($value) {
        case "true":
        case "on":
        case "1":
            $this->opt_echo = true;
            break;
        default:
            $this->opt_echo = false;
            break;
        }
    }

    /**
     * check if we have a echo print-out
     *
     * @return bool 1 if echo, 0 otherwise
     */
    public function isEcho()
    {
        return $this->opt_echo;
    }
}


