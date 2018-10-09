<?php

namespace Mellivora\MultiProcess;

class Process
{
    /**
     * 快速创建一个进程
     *
     * @param callable $target
     *
     * @return \Mellivora\MultiProcess\Process
     */
    public static function create(callable $target)
    {
        return new self($target);
    }

    use Traits\EventTrait;

    protected $target;

    protected $process;

    protected $pid;

    public function __construct(callable $target)
    {
        $this->target = $target;
    }

    public function run()
    {
    }

    public function running()
    {
    }

    public function done()
    {
    }

    public function success()
    {
    }

    public function error()
    {
    }
}
