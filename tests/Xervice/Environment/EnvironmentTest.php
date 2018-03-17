<?php
namespace XerviceTest\Environment;

use Xervice\Config\Environment\Environment;

class EnvironmentTest extends \Codeception\Test\Unit
{
    /**
     * @var \XerviceTest\XerviceTester
     */
    protected $tester;

    /**
     * @group Xervice
     * @group Config
     * @group Environment
     * @group Integration
     */
    public function testGetEnvironmentWithoutEnv()
    {
        $env = new Environment();
        $this->assertEquals(
            'production',
            $env->getEnvironment()
        );
    }

    /**
     * @group Xervice
     * @group Config
     * @group Environment
     * @group Integration
     */
    public function testGetEnvironmentWithEnv()
    {
        putenv('APPLICATION_ENV=test');

        $env = new Environment();
        $this->assertEquals(
            'test',
            $env->getEnvironment()
        );
    }
}