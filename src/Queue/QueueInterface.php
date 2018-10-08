<?php

namespace Mellivora\MultiProcess\Queue;

/**
 * 队列类接口
 */
interface QueueInterface
{
    /**
     * 从队列中获取一条数据
     *
     * @param mixed $blocking 当队列为空时，如果值为 true 则阻塞等待，否则抛出异常
     * @param mixed $timeout
     *
     * @throws QueueEmptyException
     *
     * @return bool
     */
    public function get($blocking=true, $timeout=0);

    /**
     * 新增一条数据到队列中
     *
     * @param mixed $data
     * @param mixed $blocking 当队列已满，如果值为 true 则阻塞等待，否则抛出异常
     * @param mixed $timeout  单位 microtime
     *
     * @throws \Mellivora\MultiProcess\Queue\QueueFullException
     *
     * @return bool
     */
    public function put($data, $blocking=true, $timeout=0);

    /**
     * 队列是否为空
     *
     * @return bool
     */
    public function isEmpty();

    /**
     * 队列已满，当未指定 $maxsize 时，永远为 false
     *
     * @return bool
     */
    public function isFull();

    /**
     * 返回队列最大容量，当 $maxsize!=null 时，重新调整队列大小
     *
     * @param null|mixed $maxsize
     *
     * @return int
     */
    public function maxsize($maxsize=null);

    /**
     * 返回当前队列大小
     *
     * @return int
     */
    public function size();

    /**
     * 释放队列中所有的数据
     *
     * @return true
     */
    public function free();
}
