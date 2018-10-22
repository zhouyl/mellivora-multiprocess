<?php

namespace Mellivora\MultiProcess\Process;

/**
 * 用于将信号管理器、管道等实例，附加到进程中
 */
interface Attachable
{
    /**
     * 将当前实例附加到进程上
     *
     * @param \Mellivora\MultiProcess\Process $process
     *
     * @return void
     */
    public function setup(Process $process);
}
