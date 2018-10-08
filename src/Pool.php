<?php

namespace Mellivora\MultiProcess;

use Closure;

/**
 * 进程池
 */
class Pool
{
    /**
     * 快速创建一个进程池
     *
     * @example
     *      Pool::factory(function () {}, $size=10);
     *      Pool::factory(new Task(...), $size=10);
     *      Pool::factory(new Process(...));
     *
     * @param mixed    $item
     * @param null|int $size
     *
     * @return \Mellivora\MultiProcess\Pool
     */
    public static function factory($item, $size=1)
    {
        $pool = new self;

        return $pool->put($item, $size);
    }

    /**
     * 最大进程数量
     *
     * @var int
     */
    protected $maxsize;

    /**
     * 进程池
     *
     * @var array
     */
    protected $items=[];

    /**
     * 已注册的事件
     *
     * @var array
     */
    protected $events = [];

    /**
     * 构造方法
     *
     * @param int $maxsize 最大进程数量
     */
    public function __construct($maxsize=0)
    {
        $this->maxsize = (int) $maxsize;
    }

    /**
     *  设定|获取最大进程数量
     *
     * @param null|int $maxsize
     */
    public function maxsize($maxsize=null)
    {
        if (is_numeric($maxsize)) {
            $this->maxsize = (int) $maxsize;
        }

        return $this->maxsize;
    }

    /**
     * 获取当前进程池进程/任务数量
     *
     * @return int
     */
    public function size()
    {
        return count($this->items);
    }

    /**
     * 新增一个任务到进程池中
     *
     * @param \Mellivora\MultiProcess\Task $task
     * @param int                          $size
     *
     * @throws \Mellivora\MultiProcess\Pool\PoolException
     *
     * @return \Mellivora\MultiProcess\Pool
     */
    public function putTask(Task $task, $size=1)
    {
        if ($size < 1) {
            throw new Pool\PoolException('The task size should be greater than 0');
        }

        $this->tryAddProcess($size);

        for ($i=0; $i < $size; ++$i) {
            $this->items[] = $task;
        }

        return $this;
    }

    /**
     * 添加一个进程到进程池中
     *
     * @param \Mellivora\MultiProcess\Process $process
     *
     * @return \Mellivora\MultiProcess\Pool
     */
    public function putProcess(Process $process)
    {
        $this->tryAddProcess();

        $this->items[] = $process;

        return $this;
    }

    /**
     * 新增一个回调任务到进程池中
     *
     * @param callable $task
     * @param int      $size
     *
     * @return \Mellivora\MultiProcess\Pool
     */
    public function putCallback(callable $func, $size=1)
    {
        return $this->putTask(new Task($func), $size);
    }

    /**
     * 新增一个回调任务/进程/任务到进程池中
     *
     * @param mixed $item
     * @param int   $size
     *
     * @throws \Mellivora\MultiProcess\Pool\PoolException
     *
     * @return \Mellivora\MultiProcess\Pool
     */
    public function put($item, $size=1)
    {
        if ($item instanceof Task) {
            return $this->putTask($item, $size);
        }

        if ($item instanceof Process) {
            return $this->putProcess($item);
        }

        if (is_callable($item)) {
            return $this->putCallback($item, $size);
        }

        throw new Pool\PoolException('Invalid process pool item');
    }

    /**
     * 新增事件监听
     *
     * @param string   $event
     * @param callable $callback
     *
     * @return \Mellivora\MultiProcess\Pool
     */
    public function listen($event, callable $callback)
    {
        $this->events[$event][] = $callback;

        return $this;
    }

    /**
     * 触发事件
     *
     * @param string|string[] $event
     * @param array           $args
     *
     * @return \Mellivora\MultiProcess\Pool
     */
    public function fire($event, array $args=[])
    {
        $events = isset($this->events[$event]) ? $this->events[$event] : [];

        foreach ($events as $evt) {
            // 允许在回调函数中使用 $this 访问连接池
            $closure = Closure::fromCallable($evt)->bindTo($this);

            call_user_func_array($closure, $args);
        }

        return $this;
    }

    /**
     * 判断当前进程池是否有进程在运行中
     *
     * @return bool
     */
    public function running()
    {
        return false;
    }

    /**
     * 判断当前进程池是否所有进程已运行完毕
     *
     * @return bool
     */
    public function done()
    {
        return false;
    }

    /**
     * 启动进程
     *
     * @return \Mellivora\MultiProcess\Pool
     */
    public function start()
    {
        return $this;
    }

    /**
     * 关闭pool，使其不在接受新的任务
     *
     * @return \Mellivora\MultiProcess\Pool
     */
    public function close()
    {
        return $this;
    }

    /**
     * 关闭pool，结束工作进程，不再处理未完成的任务
     *
     * @return \Mellivora\MultiProcess\Pool
     */
    public function terminate()
    {
        return $this;
    }

    /**
     * 主进程阻塞，等待子进程的退出
     *
     * @return \Mellivora\MultiProcess\Pool
     */
    public function wait()
    {
        return $this;
    }

    /**
     * 将当前进程转为无人值守
     *
     * @return \Mellivora\MultiProcess\Pool
     */
    public function daemon()
    {
        return $this;
    }

    /**
     * 尝试添加指定数量的进程，避免超过起程池限定值
     *
     * @param mixed $nums
     *
     * @throws \Mellivora\MultiProcess\Pool\PoolFullException
     */
    protected function tryAddProcess($nums=1)
    {
        if ($this->maxsize && ($this->size() + $nums) > $this->maxsize) {
            throw new Pool\PoolFullException('Process pool is full');
        }
    }
}
