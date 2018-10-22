<?php

namespace Mellivora\MultiProcess\Process;

use swoole_process;

class MasterProcess
{
    public static function instance()
    {
        if (! self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public function __construct()
    {
    }

    public function wait()
    {
        swoole_process::signal(SIGCHLD, function ($signal) {
            while (true) {
                if (! $ret = swoole_process::wait(false)) {
                    break;
                }
            }
        });
    }
}
