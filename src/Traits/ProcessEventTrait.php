<?php

namespace Mellivora\MultiProcess\Traits;

class ProcessEventTrait
{
    public function onReceive(callable $callback)
    {
        $this->listen('receive', $callback);

        return $this;
    }

    public function onStart(callable $callback)
    {
        $this->listen('start', $callback);

        return $this;
    }

    public function onStop(callable $callback)
    {
        $this->listen('stop', $callback);

        return $this;
    }

    public function onFinish(callable $callback)
    {
        $this->listen('finish', $callback);

        return $this;
    }

    public function onSuccess(callable $callback)
    {
        $this->listen('success', $callback);

        return $this;
    }

    public function onError(callable $callback)
    {
        $this->listen('error', $callback);

        return $this;
    }
}
