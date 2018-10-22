<?php

namespace Mellivora\MultiProcess\Traits;

trait EventTrait
{
    /**
     * 已注册的事件
     *
     * @var array
     */
    protected $events = [];

    /**
     * 新增事件监听
     *
     * @param string   $event
     * @param callable $callback
     *
     * @return $this
     */
    public function listen($event, callable $callback)
    {
        $this->events[$event][] = $callback;

        return $this;
    }

    /**
     * listen() 方法的别名，新增监听事件
     *
     * @param string   $event
     * @param callable $callback
     *
     * @return $this
     */
    public function on($event, callable $callback)
    {
        $this->listen($event, $callback);

        return $this;
    }

    /**
     * 触发事件
     *
     * @param string|string[] $event
     * @param mixed           ...$args
     *
     * @return $this
     */
    public function fire($event, ...$args)
    {
        $events = isset($this->events[$event]) ? $this->events[$event] : [];
        array_unshift($args, $this);

        foreach ($events as $evt) {
            call_user_func_array($evt, $args);
        }

        return $this;
    }
}
