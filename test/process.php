<?php
/**
 * Created by PhpStorm.
 * User: WalkingSun
 * Date: 2018/10/30
 * Time: 10:28
 */


$process = new swoole_process(function(swoole_process $worker){
    $worker->exec('/usr/bin/php',['/data/app/http_server.php']);
//    $worker->write('hello');
},true);
$pid = $process->start();
echo $pid.PHP_EOL;
//echo " from exec: ". $process->read(). "\n";

swoole_process::wait();   //回收结束运行的子进程。   子进程结束必须要执行wait进行回收，否则子进程会变成僵尸进程