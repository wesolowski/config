<?php

namespace XerviceTest;

use Xervice\Config\Business\XerviceConfig;
use Xervice\Config\Business\ConfigBusinessFactory;

class IntegrationTest extends \Codeception\Test\Unit
{
    /**
     * @var \XerviceTest\XerviceTester
     */
    protected $tester;

    /**
     * @var \Xervice\Config\Business\Container\ConfigContainer
     */
    private $configData;

    protected function _before()
    {
        $this->loadConfig();
    }


    /**
     * @group Xervice
     * @group Config
     * @group XerviceConfig
     *
     * @dataProvider getConfigTestData
     */
    public function testConfig($name, $value)
    {
        $this->assertEquals(
            $value,
            $this->configData->get($name)
        );
    }

    /**
     * @group Xervice
     * @group Config
     * @group XerviceConfig
     *
     * @dataProvider getStaticTestData
     */
    public function testStaticGetAndSet($name, $value)
    {
        XerviceConfig::set($name, $value);
        $this->assertEquals(
            $value,
            XerviceConfig::get($name)
        );
    }

    /**
     * @group Xervice
     * @group Config
     * @group XerviceConfig
     */
    public function testDefaultConfig()
    {
        $this->assertEquals(
            'defaultval',
            $this->configData->get('NOT_EXISTING_KEY', 'defaultval')
        );
    }

    /**
     * @group Xervice
     * @group Config
     * @group XerviceConfig
     */
    public function testConfigPath()
    {
        putenv('APPLICATION_PATH=');
        putenv('CONFIG_PATH=' . __DIR__ . '/TestConfig/config');
        $this->loadConfig();

        $this->assertEquals(
            'testDir',
            $this->configData->get('customTestDir')
        );
    }

    /**
     * @group Xervice
     * @group Config
     * @group XerviceConfig
     */
    public function testApplicationPath()
    {
        putenv('APPLICATION_PATH=' . __DIR__ . '/TestConfig');
        putenv('CONFIG_PATH=');
        $this->loadConfig();

        $this->assertEquals(
            'testDir',
            $this->configData->get('customTestDir')
        );
    }

    /**
     * @return array
     */
    public function getConfigTestData(): array
    {
        return [
            [
                'default',
                'testDefault'
            ],
            [
                'production',
                'prod_test-main'
            ],
            [
                'local',
                'local-test'
            ],
            [
                'prod_overwrite',
                'local'
            ],
            [
                'default_overwrite',
                'testProduction'
            ]
        ];
    }

    /**
     * @return array
     */
    public function getStaticTestData(): array
    {
        return [
            [
                'testString',
                'MyStringValue'
            ],
            [
                'testBool',
                true
            ],
            [
                'testArray',
                ['myTest']
            ],
            [
                'testInt',
                5
            ],
            [
                'testDouble',
                5.3
            ],
            [
                'testObject',
                new \stdClass()
            ]
        ];
    }

    private function loadConfig(): void
    {
        $config = new XerviceConfig(new ConfigBusinessFactory());
        $this->configData = $config->getConfig();
    }
}