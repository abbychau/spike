<?php

/*
 * This file is part of the slince/spike package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Spike\Common\Timer;

use Spike\Common\Logger\Logger;

class MemoryWatchTimer implements TimerInterface
{
    /**
     * @var Logger
     */
    protected $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    private static function convert($size)
    {
        $unit=array('Bytes','KB','MB','GB','TB','PB');
        return round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke()
    {
        $this->logger->info(sprintf('Memory usage: %s', $this::convert(memory_get_usage())));
    }

    /**
     * {@inheritdoc}
     */
    public function getInterval()
    {
        return 60;
    }

    /**
     * {@inheritdoc}
     */
    public function isPeriodic()
    {
        return true;
    }
}