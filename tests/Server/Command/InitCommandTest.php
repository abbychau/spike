<?php
namespace Spike\Tests\Server\Command;

use Spike\Tests\TestCase;
use Spike\Server\Command\InitCommand;
use Spike\Server\Server;
use Symfony\Component\Console\Tester\CommandTester;

class InitCommandTest extends TestCase
{

    public function testClient()
    {
        $command = new InitCommand($this->getServerMock());
        $this->assertInstanceOf(Server::class, $command->getServer());
    }

    public function testExecute()
    {
        $command = new InitCommand($this->getServerMock());
        $commandTester = new CommandTester($command);
        $dir = sys_get_temp_dir();
        $commandTester->execute([
            '--dir' => $dir
        ]);
        $this->assertFileExists("{$dir}/spiked.json");
    }

    public function testExecuteDumpError()
    {
        $command = new InitCommand($this->getServerMock());
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            '--dir' => preg_match('/win/i', PHP_OS) ? 'foo://a/' :  '/dev/null'
        ]);
        $this->assertStringContainsString('Can not create the configuration file', $commandTester->getDisplay());
    }

}