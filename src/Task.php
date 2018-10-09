<?php

namespace Mellivora\MultiProcess;

class Task
{
    /**
     * 快速创建一个任务
     *
     * @param callable $func
     *
     * @return \Mellivora\MultiProcess\Task
     */
    public static function create(callable $func)
    {
        return new self($func);
    }

    use Traits\EventTrait;

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
    protected $end;

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
            $this->fire('start', $args);

            // 绑定 $process 到回调函数中
            $closure = Closure::fromCallable($this->target)->bindTo($process);

            // 获得运行结果
            $this->result = call_user_func_array($closure, $args);
            $this->fire('success', [$this->result]);
        } catch (\Exception $e) {
            $this->exception = $e;
            $this->fire('error', [$e]);
        } finally {
            $this->end = microtime(true);
            $this->fire('done', [$this->result]);
            $this->process->exit();
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
     * 允许通过魔术方法访问 Task 属性
     * [target|process|result|exception|start|end]
     *
     * @param string $property
     *
     * @throws \Mellivora\MultiProcess\Task\TaskException
     *
     * @return mixed
     */
    public function __get($property)
    {
        if (! property_exists($this, $property)) {
            throw new Task\TaskException(sprintf(
                'Invalid property %s::%s',
                __CLASS__,
                $property
            ));
        }

        return $this->{$property};
    }
}
