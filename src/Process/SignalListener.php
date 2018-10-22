<?php

namespace Mellivora\MultiProcess\Process;

use swoole_process;

class SignalListener implements Attachable
{
    /**
     * 已注册监听的信号
     *
     * @var callable[]
     */
    protected $listeners = [];

    /**
     * 监听一个/多个系统信号
     *
     * @param mixed    $signals
     * @param callable $listener
     *
     * @return \Mellivora\MultiProcess\Process\SignalListener
     */
    public function on($signals, callable $listener)
    {
        foreach (is_array($signals) ? $signals : [$signals] as $sigal) {
            $this->listeners[$sigal] = $listener;
        }

        return $this;
    }

    /**
     * 监听系统意外退出信号 (SIGINT|SIGQUIT|SIGTERM)
     *
     * @param callable $listener
     *
     * @return \Mellivora\MultiProcess\Process\SignalListener
     */
    public function onAbend(callable $listener)
    {
        return $this->on([SIGINT, SIGQUIT, SIGTERM], $listener);
    }

    /**
     * {@inheritdoc}
     */
    public function setup(Process $process)
    {
        foreach ($this->listeners as $signal => $listener) {
            echo "install SignalListener: signo=$signal, pid={$process->getPid()}\n";
            swoole_process::signal(
                $signal,
                function ($signo) use ($listener, $process) {
                    return call_user_func($listener, $signo, $process);
                }
            );
        }
    }
}
