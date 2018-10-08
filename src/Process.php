<?php

namespace Mellivora\MultiProcess;

class Process
{
    /**
     * 快速创建一个进程
     *
     * @param mixed $item
     *
     * @return \Mellivora\MultiProcess\Process
     */
    public static function factory($item)
    {
        $process = new self;

        return $process->add($item);
    }

    protected $process;

    protected $pid;

    public function addCallback(callable $func)
    {
    }

    public function addTask(Task $task)
    {
    }

    public function add()
    {
    }

    public function run()
    {
    }
}
