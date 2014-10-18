<?php
require __DIR__.'/../../vendor/autoload.php';
use Core\Browser;
class BrowserTest extends \PHPUnit_Framework_TestCase
{
    public $object;
    public $test_path;
    public $wrong_path;
    protected function setUp()
    {
        $this->object = new Browser();
        $this->test_path = getcwd() . '/docs';
        $this->wrong_path = 'file';
    }
    /**
     * test to see if browser method listDirectory will return an error on wrong given path
     *
     * @test
     * @covers Browser::listDirectory
     */
    public function testIfBrowserClassWillReturnErrorOnWrongPAth()
    {
        $this->assertArrayHasKey('ERROR', $this->object->listDirectory($this->wrong_path));
    }
    /**
     * test to see if browser method listDirectory will return an proper array on correctly given path
     * i will use this very folder where is located this test file
     *
     * @test
     * @covers Browser::listDirectory
     */
    public function testIfBrowserClassWillReturnCorrectArrayOnCorrectPath()
    {
        $result = $this->object->listDirectory($this->test_path);
        foreach ($result as $list)
        {
            $this->assertArrayHasKey('name', $list);
        }
    }
    /**
     * test to see if getCorrectModificationTime will return intgers
     *
     * @test
     * @covers Browser::getCorrectModificationTime
     */
    public function testIfgetCorrectModificationTimeWilReturnINteger()
    {
        $this->assertInternalType('integer', $this->object->getCorrectModificationTime(getcwd() . '/tests/unit/_bootstrap.php'));
    }
}