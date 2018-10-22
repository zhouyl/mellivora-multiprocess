<?php

namespace Mellivora\MultiProcess\Process;

use Mellivora\MultiProcess\Traits\EventTrait;
use swoole_process;

class Process
{
    /**
     * 快速创建一个进程
     *
     * @param callable $target
     *
     * @return \Mellivora\MultiProcess\Process\Process
     */
    public static function create(callable $target)
    {
        return new static($target);
    }

    use EventTrait;

    /**
     * 需要执行的任务
     *
     * @var callable
     */
    protected $target;

    /**
     * 进程附加组件
     *
     * @var \Mellivora\MultiProcess\Process\Attachable[]
     */
    protected $attachments = [];

    /**
     * Swoole 进程
     *
     * @var \swoole_process
     */
    protected $process;

    /**
     * 进程名称
     *
     * @var string
     */
    protected $name;

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
    protected $end;

    /**
     * 构造方法
     *
     * @param callable $target
     */
    public function __construct(callable $target)
    {
        $this->target = $target;
    }

    /**
     * 附加一个组件到进程中(每种类型的组件仅允许附加一个)
     *
     * @param \Mellivora\MultiProcess\Process\Attachable $object
     *
     * @return \Mellivora\MultiProcess\Process\Process
     */
    public function attach(Attachable $object)
    {
        $this->attachments[get_class($object)] = $object;

        return $this;
    }

    /**
     * 为当前进程设置进程名
     *
     * @param string $name
     *
     * @return \Mellivora\MultiProcess\Process\Process
     */
    public function setName($name)
    {
        $this->name = (string) $name;

        if ($this->process) {
            $this->process->name($name);
        }

        return $this;
    }

    /**
     * 获取当前进程名
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * 获取 swoole 进程
     *
     * @return \swoole_process
     */
    public function getProcess()
    {
        return $this->process;
    }

    /**
     * 获取当前进程 pid
     *
     * @return int
     */
    public function getPid()
    {
        return $this->pid;
    }

    /**
     * 进程启动
     *
     * @throws \Mellivora\MultiProcess\Process\ProcessException
     *
     * @return \Mellivora\MultiProcess\Process\Process
     */
    public function start()
    {
        if ($this->isStarted()) {
            throw new ProcessException('The process is already started.');
        }

        $this->process = new swoole_process(function ($process) {
            $this->pid = $process->pid;
            $this->start = microtime(true);

            // 设置进程名称
            if ($this->name) {
                $process->name($this->name);
            }
            // $this->setupSignals($process);

            // 安装附加组件
            foreach ($this->attachments as $object) {
                $object->setup($this);
            }

            // 执行任务
            call_user_func($this->target, $this);

            $this->end = microtime(true);

            $process->exit();
        }, false);

        $this->process->start();

        return $this;
    }

    // public function terminate()
    // {
    //     return $this->process->exit();
    // }

    /**
     * 阻塞等待进程运行结束
     *
     * @return \Mellivora\MultiProcess\Process\Process
     */
    public function wait()
    {
        swoole_process::wait(true);

        return $this;
    }

    /**
     * 判断进程是否已启动
     *
     * @return bool
     */
    public function isStarted()
    {
        return $this->start > 0;
    }

    /**
     * 判断进程是否运行中
     *
     * @return bool
     */
    public function isRunning()
    {
        return $this->pid && swoole_process::kill(0, $this->pid);
    }

    /**
     * 判断进程是否已运行完毕
     *
     * @return bool
     */
    public function isFinished()
    {
        return $this->start && $this->end;
    }

    public function __get($name)
    {
        if (property_exists($this->process, $name)) {
            return $this->process->{$name};
        }

        throw new Exception('Invalid property ' . __CLASS__ . '::' . $name);
    }

    public function __call($method, $args)
    {
        throw new Exception("invalid method [$method]");

        return call_user_func_array([$this->process, $method], $args);
    }

    // protected function setupEventIO(swoole_process $process)
    // {
    //     if ($this->onReceive) {
    //         swoole_event_add($process->pipe, function ($pipe) use ($process) {
    //             return call_user_func($this->onReceive, $process);
    //         });
    //     }
    // }
}
