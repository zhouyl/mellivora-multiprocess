<?php

namespace Mellivora\MultiProcess\Traits;

use Closure;

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
        return $this->listen($event, $callback);
    }

    /**
     * 触发事件
     *
     * @param string|string[] $event
     * @param array           $args
     *
     * @return $this
     */
    public function fire($event, array $args=[])
    {
        $events = isset($this->events[$event]) ? $this->events[$event] : [];

        foreach ($events as $evt) {
            call_user_func_array(
                // 允许在回调函数中使用 $this 访问连接池
                Closure::fromCallable($evt)->bindTo($this),
                $args
            );
        }

        return $this;
    }
}
