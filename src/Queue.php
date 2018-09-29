<?php

namespace Mellivora\MultiProcess;

class Queue
{
    /**
     * @example
     *      Queue::fifo();
     *      Queue::lifo();
     *      Queue::priority();
     *
     * @param mixed $name
     * @param mixed $arguments
     *
     * @return \Mellivora\MultiProcess\Queue\QueueInterface
     */
    public static function __callStatic($name, $arguments)
    {
    }
}
