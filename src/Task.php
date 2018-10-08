<?php

namespace Mellivora\MultiProcess;

class Task
{
    /**
     * 任务运行进程
     */
    protected $process;

    /**
     * 任务工作内容
     */
    protected $target;

    /**
     * 任务运行结果
     */
    protected $result;

    /**
     * 任务运行过程中捕获的异常
     */
    protected $exception;

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
     * @param callable $target 任务内容
     */
    public function __construct(callable $target)
    {
        $this->target = $target;
    }

    /**
     * 运行任务
     *
     * @param \Mellivora\MultiProcess\Process $process
     * @param array                           $args
     *
     * @return \Mellivora\MultiProcess\Task
     */
    public function run(Process $process, array $args=[])
    {
        $this->process   = $process;
        $this->start     = microtime(true);
        $this->result    = null;
        $this->exception = null;
        $this->end       = null;

        try {
            // 绑定当前 task 到回调函数中
            $closure = Closure::fromCallable($this->target)->bindTo($this);

            // 获得运行结果
            $this->result = call_user_func_array($closure, $args);
        } catch (\Exception $e) {
            $this->exception = $e;
        }

        $this->end = microtime(true);

        return $this;
    }

    /**
     * 获取任务进程
     *
     * @return \Mellivora\MultiProcess\Process
     */
    public function process()
    {
        return $this->process;
    }

    /**
     * 获取任务进程 pid
     *
     * @return int
     */
    public function pid()
    {
        return $this->process ? $this->process->pid : 0;
    }

    /**
     * 判断任务是否正在执行中
     *
     * @return bool
     */
    public function running()
    {
        return $this->process && $this->start && ! $this->end;
    }

    /**
     * 判断任务是否已执行完毕
     *
     * @return bool
     */
    public function done()
    {
        return $this->process && $this->start && $this->end;
    }

    /**
     * 判断任务是否已执行完毕并成功
     *
     * @return bool
     */
    public function success()
    {
        return $this->done() && ! $this->exception;
    }

    /**
     * 判断任务是否已执行完毕并失败
     *
     * @return bool
     */
    public function fail()
    {
        return $this->done() && $this->exception;
    }

    /**
     * 获取任务运行结果
     *
     * @return mixed
     */
    public function result()
    {
        return $this->result;
    }

    /**
     * 获取任务执行时的异常
     *
     * @return \Exception
     */
    public function exception()
    {
        return $this->execption;
    }

    /**
     * 获取任务执行时长
     *
     * @return float
     */
    public function exectime()
    {
        return microtime(true) - $this->start;
    }

    /**
     * 允许通过魔术方法访问部分属性
     *
     * @param string $name
     *
     * @throws \Mellivora\MultiProcess\Exception
     *
     * @return mixed
     */
    public function __get($name)
    {
        $props = ['process', 'pid', 'result', 'exeception'];
        if (! in_array($name, $props)) {
            throw new Exception(sprintf(
                'Invalid property %s::%s',
                __CLASS__,
                $name
            ));
        }

        return $this->{$name}();
    }
}
