<?php

namespace Mellivora\MultiProcess;

class Pool
{
    /**
     * 构造方法
     *
     * @param callable $callback 可执行的回调函数或者方法
     * @param array    $args     执行回调的参数
     * @param mixed    $maxsize  最大进程数量
     */
    public function __construct(Job $job, $maxsize=0)
    {
    }

    /**
     *  设定|获取最大进程数量
     *
     * @param null|int $maxsize
     */
    public function maxsize($maxsize=null)
    {
    }

    /**
     * 新增一个任务到进程池中
     *
     * @param \Mellivora\MultiProcess\Job $job
     */
    public function putJob(Job $job)
    {
    }

    /**
     * 添加一个进程到 pool 中
     *
     * @param \Mellivora\MultiProcess\Process $process
     */
    public function putProcess(Process $process)
    {
    }

    /**
     * 根据 $callback & $args 自动创建进程，并返回一个 AsyncResult 结果
     *
     * @param mixed    $callback
     * @param callable $callback 可执行的回调函数或者方法
     * @param array    $args     执行回调的参数
     *
     * @return \Mellivora\MultiProcess\AsyncResult
     */
    public function async(callable $callback, array $args=[])
    {
    }

    /**
     * 获取已执行完成的进程结果
     *
     * @return \Mellivora\MultiProcess\Result[]
     */
    public function results()
    {
    }

    /**
     * 启动进程
     */
    public function start()
    {
    }

    /**
     * 关闭pool，使其不在接受新的任务
     */
    public function close()
    {
    }

    /**
     * 关闭pool，结束工作进程，不在处理未完成的任务
     */
    public function terminate()
    {
    }

    /**
     * 主进程阻塞，等待子进程的退出，join方法要在close或terminate之后使用
     */
    public function join()
    {
    }

    /**
     * 将当前进程转为无人值守
     */
    public function daemon()
    {
    }
}
