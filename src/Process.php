<?php

namespace Mellivora\MultiProcess;

class Process
{
    protected $process;
    protected $pid;
    protected $startTime;

    public function start()
    {
        $this->startTime = microtime(true);

        return $this;
    }

    public function stop()
    {
        return $this;
    }

    public function isRunning()
    {
    }

    public function isSuccessful()
    {
    }

    public function isTerminated()
    {
    }

    public function getProcess()
    {
    }

    public function getPid()
    {
    }

    public function getExecutionTime()
    {
        return microtime(true) - $this->startTime;
    }
}
