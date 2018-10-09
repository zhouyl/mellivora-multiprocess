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
    protected $end;

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
            $this->end = null;
            $this->fire('start', $process);

            $this->task->start($this);

            $this->end = microtime(true);
            $this->fire('exit', $process);
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

        $this->process->start();

        return $this;
    }

    /**
     * 获取当前进程 pid
     *
     * @return int
     */
    public function pid()
    {
        return $this->process->pid;
    }

    /**
     * 发送 unix 信号以结束进程
     *
     * @param int $signo
     *
     * @return \Mellivora\MultiProcess\Process
     */
    public function kill($signo=SIGTERM)
    {
        if ($this->running() && signal_kill($signo, $this->pid())) {
            $this->end = microtime(true);
            $this->fire('exit', $this->process);
        }

        return $this;
    }

    /**
     * 判断进程是否运行中
     *
     * @return bool
     */
    public function running()
    {
        return $this->pid() && signal_kill(0, $this->pid());
    }

    /**
     * 判断进程是否已退出
     *
     * @return bool
     */
    public function done()
    {
        return $this->pid() && $this->end;
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
