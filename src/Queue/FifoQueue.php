<?php

namespace Mellivora\MultiProcess\Queue;

class FifoQueue implements QueueInterface
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
    public function empty()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function full()
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
