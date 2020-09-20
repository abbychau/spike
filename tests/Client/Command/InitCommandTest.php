<?php
namespace Spike\Tests\Client\Command;

use Spike\Tests\TestCase;
use Spike\Client\Command\InitCommand;
use Spike\Client\Client;
use Symfony\Component\Console\Tester\CommandTester;

class InitCommandTest extends TestCase
{

    protected function getApplicationMock()
    {
        return $this->getMockBuilder(Client::class)
            ->setMethods(null)
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function testClient()
    {
        $command = new InitCommand($this->getClientStub());
        $this->assertInstanceOf(Client::class, $command->getClient());
    }

    public function testExecute()
    {
        $command = new InitCommand($this->getClientStub());
        $commandTester = new CommandTester($command);
        $dir = sys_get_temp_dir();
        $commandTester->execute([
            '--dir' => $dir
        ]);
        $this->assertFileExists("{$dir}/spike.json");
    }

    public function testExecuteDumpError()
    {
        $command = new InitCommand($this->getClientStub());
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            '--dir' => preg_match('/win/i', PHP_OS) ? 'foo://a/' :  '/dev/null'
        ]);
        $this->assertStringContainsString('Can not create the configuration file', $commandTester->getDisplay());
    }

}