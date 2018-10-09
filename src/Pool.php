<?php

namespace Mellivora\MultiProcess;

/**
 * 进程池
 */
class Pool
{
    /**
     * 快速创建一个进程池
     *
     * @example
     *      Pool::create(function () {}, $size=10);
     *      Pool::create(new Task(...), $size=10);
     *      Pool::create(new Process(...));
     *
     * @param mixed    $item
     * @param null|int $size
     *
     * @return \Mellivora\MultiProcess\Pool
     */
    public static function create($item, $size=1)
    {
        $pool = new self;

        return $pool->put($item, $size);
    }

    use Traits\EventTrait;

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
     * 添加一个进程到进程池中
     *
     * @param \Mellivora\MultiProcess\Process $process
     *
     * @return \Mellivora\MultiProcess\Pool
     */
    public function putProcess(Process $process)
    {
        $this->tryAddItem();

        $this->items[] = $process;

        return $this;
    }

    /**
     * 新增一个回调任务到进程池中
     *
     * @param callable $callback
     * @param int      $size
     *
     * @return \Mellivora\MultiProcess\Pool
     */
    public function putCallback(callable $callback, $size=1)
    {
        if ($size < 1) {
            throw new Pool\PoolException('The task size should be greater than 0');
        }

        $this->tryAddItem($size);

        if (! $callback instanceof Task) {
            $callback = Task::create($callback);
        }

        for ($i=0; $i < $size; ++$i) {
            $this->items[] = $callback;
        }

        return $this;
    }

    /**
     * 尝试添加指定数量的进程，避免超过起程池限定值
     *
     * @param mixed $size
     *
     * @throws \Mellivora\MultiProcess\Pool\PoolFullException
     */
    protected function tryAddItem($size=1)
    {
        if ($this->maxsize && ($this->size() + $size) > $this->maxsize) {
            throw new Pool\PoolFullException('Process pool is full');
        }
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
        if ($item instanceof Process) {
            return $this->putProcess($item);
        }

        if (is_callable($item)) {
            return $this->putCallback($item, $size);
        }

        throw new Pool\PoolException('Invalid process pool item');
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
}
