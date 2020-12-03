<?php
/*
 * @Author: llseng 
 * @Date: 2020-11-21 18:22:47 
 * @Last Modified by: llseng
 * @Last Modified time: 2020-11-21 19:16:03
 */
namespace App\Traits;

/**
 * 进程管理工具
 */
trait ProcTool
{

    static public function verify() {
        if( !extension_loaded( 'pcntl' ) || !extension_loaded( 'posix' ) ) {
            die('You must install PCNTL POSIX extension!');
        }
    }

    /**
     * 检测子进程是否正在运行
     *
     * @param int $pid
     * @return boolean
     */
    static public function isRunning( $pid ) {
        return \posix_kill( \intval( $pid ), 0 ); 
    }

    /**
     * 杀死子进程
     *
     * @param int $pid
     * @param int $sig
     * @return void
     */
    static public function kill( $pid, $sig = null ) {
        \is_null( $sig ) && $sig = SIGKILL;
        return \posix_kill( \intval( $pid ), $sig );
    }

    /**
     * 开启守护进程
     */
    static public function daemon( ) {
        $pid = \pcntl_fork();
        if (-1 === $pid) {
            die( "daemon error" );
        } elseif ($pid > 0) {
            echo( "daemon success" );
            exit(0);
        }

        if (-1 === \posix_setsid()) {
            die( "daemon error" );
        }
        // Fork again avoid SVR4 system regain the control of terminal.
        $pid = \pcntl_fork();
        if (-1 === $pid) {
            die( "daemon error" );
        } elseif (0 !== $pid) {
            exit(0);
        }
    }

    /**
     * 设执行用户
     *
     * @param string $user
     * @param string $group
     * @return bool
     */
    static public function setUser( $user, $group = null ) {
        $user_info = \posix_getpwnam( $user );
        if( empty( $user_info ) ) {
            echo "User $user not exists\n";
            return false;
        }

        $uid = $user_info['uid'];
        $gid = $user_info['gid'];
        // Set uid and gid.
        if ($uid !== \posix_getuid() || $gid !== \posix_getgid()) {
            if (!\posix_setgid($gid) || !\posix_initgroups($user_info['name'], $gid) || !\posix_setuid($uid)) {
                echo "Change user $user fail\n";
                return false;
            }
        }

        return true;
    }

}
