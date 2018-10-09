<?php

namespace Mellivora\MultiProcess;

use Closure;

class Task
{
    /**
     * 快速创建一个任务
     *
     * @param callable $target
     *
     * @return \Mellivora\MultiProcess\Task
     */
    public static function create(callable $target)
    {
        if ($target instanceof self) {
            return $target;
        }

        return new self($target);
    }

    use Traits\EventTrait;
    use Traits\PropertyAccessTrait;

    /**
     * 任务工作内容
     */
    protected $target;

    /**
     * 任务运行进程
     */
    protected $process;

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
    protected $done;

    /**
     * 构造方法
     *
     * @param callable $target 任务内容
     */
    public function __construct(callable $target)
    {
        if ($target instanceof self) {
            throw new Task\TaskException('Illegal target object');
        }

        $this->target = $target;
    }

    /**
     * 运行任务
     *
     * @param \Mellivora\MultiProcess\Process $process
     *
     * @return \Mellivora\MultiProcess\Task
     */
    public function run(Process $process)
    {
        $this->process      = $process;
        $this->start        = microtime(true);
        $this->result       = null;
        $this->exception    = null;
        $this->done         = 0.0;

        try {
            $this->fire('start', [$process]);

            // 绑定 $process 到回调函数中
            $closure = Closure::fromCallable($this->target)->bindTo($process);

            // 获得运行结果
            $this->result = call_user_func($closure, $process);
            $this->fire('success', [$process, $this->result]);
        } catch (\Exception $e) {
            $this->exception = $e;
            $this->fire('error', [$process, $e]);
        } finally {
            $this->done = microtime(true);
            $this->fire('done', [$process, $this->result]);
        }

        return $this;
    }

    /**
     * 通过魔术方法将 task 转换为 callable 来运行任务
     *
     * @param \Mellivora\MultiProcess\Process $process
     * @param array                           $args
     *
     * @return \Mellivora\MultiProcess\Task
     */
    public function __invoke(Process $process, array $args=[])
    {
        return $this->run($process, $args);
    }

    /**
     * 判断任务是否正在执行中
     *
     * @return bool
     */
    public function running()
    {
        return $this->start && ! $this->done;
    }

    /**
     * 判断任务是否已执行完毕
     *
     * @return bool
     */
    public function done()
    {
        return $this->start && $this->done;
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
    public function error()
    {
        return $this->done() && $this->exception;
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
     * 事件监听 - 任务开始执行
     *
     * @param callable $callback
     *
     * @return \Mellivora\MultiProcess\Task
     */
    public function onStart(callable $callback)
    {
        return $this->listen('start', $callback);
    }

    /**
     * 事件监听 - 任务执行成功
     *
     * @param callable $callback
     *
     * @return \Mellivora\MultiProcess\Task
     */
    public function onSuccess(callable $callback)
    {
        return $this->listen('success', $callback);
    }

    /**
     * 事件监听 - 任务执行出错
     *
     * @param callable $callback
     *
     * @return \Mellivora\MultiProcess\Task
     */
    public function onError(callable $callback)
    {
        return $this->listen('error', $callback);
    }

    /**
     * 事件监听 - 任务执行完成(不论成功失败)
     *
     * @param callable $callback
     *
     * @return \Mellivora\MultiProcess\Task
     */
    public function onDone(callable $callback)
    {
        return $this->listen('done', $callback);
    }
}
