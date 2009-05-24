<?php
if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'PHP_Shell_AllTests::main');
}

require_once 'PHPUnit/TextUI/TestRunner.php';
require_once 'PHPUnit/Framework/TestSuite.php';

require_once 'ShellTest.php';

class PHP_Shell_AllTests {

    public static function main() {
        PHPUnit_TextUI_TestRunner::run(self::suite());
    }

    public static function suite() {
        $suite = new PHPUnit_Framework_TestSuite( "Shell Tests");
        $suite->addTestSuite('ShellTest');
        return $suite;
    }

}

if (PHPUnit_MAIN_METHOD == 'PHP_Shell_AllTests::main') {
    PHP_Shell_AllTests::main();
}

