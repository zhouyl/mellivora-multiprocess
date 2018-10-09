<?php

namespace Mellivora\MultiProcess;

use swoole_process;

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
    use Traits\PropertyAccessTrait;

    /**
     * Task 任务
     *
     * @var \Mellivora\MultiProcess\Task
     */
    protected $task;

    /**
     * Swoole 进程
     *
     * @var \swoole_process
     */
    protected $process;

    /**
     * 进程 pid
     *
     * @var int
     */
    protected $pid = 0;

    /**
     * 任务运行开始时间
     *
     * @var float
     */
    protected $start;

    /**
     * 任务运行结束时间
     *
     * @var float
     */
    protected $exit;

    /**
     * 构造方法
     *
     * @param callable $target
     */
    public function __construct(callable $target)
    {
        $this->task    = Task::create($target);
        $this->process = $this->createSwooleProcess();
    }

    /**
     * 创建 swoole 进程
     *
     * @return \swoole_process
     */
    protected function createSwooleProcess()
    {
        return new swoole_process(function ($process) {
            $this->start = microtime(true);
            $this->exit = null;
            $this->fire('start', [$process]);

            $this->task->run($this);

            $this->exit = microtime(true);
            $this->fire('exit', [$process]);
            $process->exit();
        });
    }

    /**
     * 进程启动
     *
     * @throws \Mellivora\MultiProcess\Process\ProcessException
     *
     * @return \Mellivora\MultiProcess\Process
     */
    public function start()
    {
        if ($this->start) {
            throw new Process\ProcessException('The process is already running');
        }

        $this->pid = $this->process->start();

        return $this;
    }

    /**
     * 让运行中的进程退出
     *
     * @return int
     */
    public function exit()
    {
        if ($this->exited) {
            return 0;
        }

        return $this->process->exit();
    }

    /**
     * 判断进程是否运行中
     *
     * @return bool
     */
    public function running()
    {
        return $this->start && ! $this->exit;
    }

    /**
     * 判断进程是否已退出
     *
     * @return bool
     */
    public function exited()
    {
        return $this->start && $this->exit;
    }

    /**
     * 事件监听 - 进程启动
     *
     * @param callable $callback
     *
     * @return \Mellivora\MultiProcess\Process
     */
    public function onStart(callable $callback)
    {
        return $this->listen('start', $callback);
    }

    /**
     * 事件监听 - 进程结束
     *
     * @param callable $callback
     *
     * @return \Mellivora\MultiProcess\Process
     */
    public function onExit(callable $callback)
    {
        return $this->listen('exit', $callback);
    }

    /**
     * 注册 task 事件监听
     *
     * @param string   $event
     * @param callable $callback
     *
     * @return \Mellivora\MultiProcess\Process
     */
    public function onTask($event, callable $callback)
    {
        $this->task->on($event, $callback);

        return $this;
    }
}
