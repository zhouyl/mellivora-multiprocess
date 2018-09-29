<?php

defined('OS_UNIX') && define('OS_UNIX', 1);
defined('OS_LINUX') && define('OS_LINUX', 2);
defined('OS_DARWIN') && define('OS_DARWIN', 4);
defined('OS_WINDOWS') && define('OS_WINDOWS', 8);

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

if (! function_exists('is_osx')) {
    /**
     * 判断当前是否 os x 操作系统
     *
     * @return bool
     */
    function is_osx()
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
     * @param null|swoole_process $worker
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
