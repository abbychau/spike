<?php
namespace Spike\Tests\Server;

use PHPUnit\Framework\TestCase;
use Spike\Server\Configuration;

class ConfigurationTest extends TestCase
{
    public function testConstruct()
    {
        $configuration = new Configuration();
        $this->assertEquals('0.0.0.0:8090', $configuration->getAddress());
        $this->assertStringContainsString('spiked.json', $configuration->getDefaultConfigFile());
        $this->assertNull($configuration->getAuthentication());
    }

    public function testGetter()
    {
        $configuration = new Configuration();
        $this->assertEquals('Asia/shanghai', $configuration->getTimezone());
        $this->assertEquals( getcwd() . '/access.log', $configuration->getLogFile());
        $this->assertEquals( 'info', $configuration->getLogLevel());

        $configuration->load(__DIR__ . '/../Fixtures/base-config.json');
        $this->assertEquals('Asia/prc', $configuration->getTimezone());
        $this->assertEquals( '/access.log', $configuration->getLogFile());
        $this->assertEquals( 'warning', $configuration->getLogLevel());
    }
}