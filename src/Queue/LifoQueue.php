<?php

namespace Mellivora\MultiProcess\Queue;

/**
 * 后进先出队列
 */
class LifoQueue implements QueueInterface
{
    /**
     * {@inheritdoc}
     */
    public function get($blocking=true, $timeout=0)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function put($data, $blocking=true, $timeout=0)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function isEmpty()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function isFull()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function maxsize($maxsize=null)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function size()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function free()
    {
    }
}
