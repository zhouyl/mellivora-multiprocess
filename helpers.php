<?php

require_once __DIR__ . '/defined.php';

if (! function_exists('os')) {
    /**
     * 判断当前操作系统类型
     *
     * @return int
     */
    function os()
    {
        // Linux
        if (stripos(PHP_OS, 'linux') === 0) {
            return OS_LINUX;
        }

        // Darwin
        if (stripos(PHP_OS, 'darwin') === 0) {
            return OS_DARWIN;
        }

        // CYGWIN_NT-5.1|WIN32|WINNT|Windows
        if (stripos(PHP_OS, 'win') === 0) {
            return OS_WINDOWS;
        }

        // other unix: FreeBSD|HP-UX|IRIX64|NetBSD|OpenBSD|SunOS|Unix|...
        return OS_UNIX;
    }
}

if (! function_exists('is_win')) {
    /**
     * 判断当前是否 win 操作系统
     *
     * @return bool
     */
    function is_win()
    {
        return os() === OS_WINDOWS;
    }
}

if (! function_exists('is_linux')) {
    /**
     * 判断当前是否 linux 操作系统
     *
     * @return bool
     */
    function is_linux()
    {
        return os() === OS_LINUX;
    }
}

if (! function_exists('is_darwin')) {
    /**
     * 判断当前是否 os x 操作系统
     *
     * @return bool
     */
    function is_darwin()
    {
        return os() === OS_DARWIN;
    }
}

if (! function_exists('is_unix')) {
    /**
     * 判断当前是否 unix 操作系统 (包括 linux/osx 都属于 unix)
     *
     * @return bool
     */
    function is_unix()
    {
        return os() !== OS_WINDOWS;
    }
}

if (! function_exists('is_cli')) {
    /**
     * 判断当前是否运行在 cli 命令行模式下
     *
     * @return bool
     */
    function is_cli()
    {
        return in_array(php_sapi_name(), ['cli', 'phpdbg'], true);
    }
}

if (! function_exists('pid')) {
    /**
     * 获取当前|指定进程的 pid
     *
     * @param null|swoole_process $worker 可以获取当前进程或指定 swoole_process 进程的pid
     *
     * @return int
     */
    function pid(swoole_process $worker=null)
    {
        if ($worker) {
            return $worker->pid;
        }

        if (function_exists('posix_getpid') && is_unix()) {
            return posix_getpid();
        }

        if (function_exists('getmypid')) {
            return getmypid();
        }

        trigger_error('Unable to get process pid', E_USER_ERROR);
    }
}

if (! function_exists('signal_listen')) {
    /**
     * 新增信号管理器
     *
     * @param int|int[] $signals 可以是一个信号或者一个信号数组
     * @param callable  $handle  信号响应回调函数
     *
     * @return bool
     */
    function signal_listen($signals, callable $handle)
    {
        is_array($signals) || $signals = [$signals];

        foreach ($signals as $signo) {
            swoole_process::signal($signo, $handle);
        }

        return true;
    }
}

if (! function_exists('signal_kill')) {
    /**
     * 向进程发送 kill 信号
     *
     * @param int      $signo unix 系统信号
     * @param null|int $pid   如果不指定进程 pid，则默认为当前进程
     */
    function signal_kill($signo, $pid=null)
    {
        $pid || $pid = pid();

        return swoole_process::kill($pid, $signo);
    }
}

if (! function_exists('signal_wait')) {
    /**
     * 执行进程回收
     *
     * @param bool $blocking 是否阻塞等待
     *
     * @return array
     */
    function signal_wait($blocking = true)
    {
        return swoole_process::wait($blocking);
    }
}

if (! function_exists('async')) {
    /**
     * 启动一个进程，异步执行 callback
     *
     * @param callable $callback
     *
     * @return swoole_process
     */
    function async(callable $callback)
    {
        $process = new swoole_process($callback);
        $process->start();

        return $process;
    }
}

if (! function_exists('await')) {
    /**
     * 调用 swoole_process::wait()，wait 结束后执行 callback
     *
     * @param null|callable $callback
     *
     * @return bool|mixed
     */
    function await(callable $callback=null)
    {
        $success = swoole_process::wait() !== false;

        return $callback($success) ? $callback : $success;
    }
}
