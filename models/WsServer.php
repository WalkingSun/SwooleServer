<?php
/**
 * Created by PhpStorm.
 * User: WalkingSun
 * Date: 2018/10/28
 * Time: 15:54
 */

class WsServer
{
    const host = '0.0.0.0';
    const port = '9501';

    public function __construct()
    {
        $ws = new Swoole_websocket_server(self::host,self::port);

        $ws->set([
            'worker_num' => 4,
            'task_worker_num' => 2,
        ]);

        $ws->on('open',[$this,'onOpen']);
        $ws->on('message',[$this,'onMessage']);
        $ws->on('task',[$this,'onTask']);            //增加task任务进程
        $ws->on('finish',[$this,'onFinish']);
        $ws->on('close',[$this,'onClose']);

        $ws->start();
    }

    /**
     * 当WebSocket客户端与服务器建立连接并完成握手后会回调此函数
     * @param $serv swoole_websocket_server 服务对象
     * @param $request swoole_http_server 服务对象
     */
    public function onOpen( swoole_websocket_server $serv,  $request){
        echo "server handshake with fd={$request->fd}\n";
    }

    /**
     *当服务器收到来自客户端的数据帧时会回调此函数。
     * @param $server  swoole_websocket_server 服务对象
     * @param $frame  swoole_websocket_frame对象，包含了客户端发来的数据帧信息
     * $frame->fd，客户端的socket id，使用$server->push推送数据时需要用到
    $frame->data，数据内容，可以是文本内容也可以是二进制数据，可以通过opcode的值来判断
    $frame->opcode，WebSocket的OpCode类型，可以参考WebSocket协议标准文档
    $frame->finish， 表示数据帧是否完整，一个WebSocket请求可能会分成多个数据帧进行发送（底层已经实现了自动合并数据帧，现在不用担心接收到的数据帧不完整）
     */
    public function onMessage(swoole_websocket_server $serv, swoole_websocket_frame $frame ){
        echo "receive from client {$frame->fd} infos: {$frame->data}-{$frame->opcode}-{$frame->finish}\n";

        $data = [
            'task'  => 1,
            'fd' => $frame->fd
        ];
        $serv->task($data);
        $serv->push($frame->fd,"server push :".date('Y-m-d H:i:s'));
    }

    /**
     * @param $serv  swoole_websocket_server 服务对象
     * @param $fd  连接的文件描述符
     * @param $reactorId  来自那个reactor线程
     * onClose回调函数如果发生了致命错误，会导致连接泄漏。通过netstat命令会看到大量CLOSE_WAIT状态的TCP连接
     * 当服务器主动关闭连接时，底层会设置此参数为-1，可以通过判断$reactorId < 0来分辨关闭是由服务器端还是客户端发起的。
     */
    public function onClose( swoole_websocket_server $serv , $fd , $reactorId ){
        echo "reactor-{$reactorId} client close {$fd}\n";
    }

    /**
     * 在task_worker进程内被调用。worker进程可以使用swoole_server_task函数向task_worker进程投递新的任务。当前的Task进程在调用onTask回调函数时会将进程状态切换为忙碌，这时将不再接收新的Task，当onTask函数返回时会将进程状态切换为空闲然后继续接收新的Task。
     * @param $serv  swoole_websocket_server 服务对象
     * @param $task_id int 任务id，由swoole扩展内自动生成，用于区分不同的任务。$task_id和$src_worker_id组合起来才是全局唯一的，不同的worker进程投递的任务ID可能会有相同
     * @param $src_worker_id int 来自于哪个worker进程
     * @param $data mixed 任务的内容
     */
    public function onTask(swoole_server $serv,  $task_id,  $src_worker_id,  $data){
        //todo 任务

        sleep(10);
        //onTask函数中 return字符串，表示将此内容返回给worker进程。worker进程中会触发onFinish函数，表示投递的task已完成。
        return "task {$src_worker_id}-{$task_id} success";
    }

    /**
     * 当worker进程投递的任务在task_worker中完成时，task进程会通过swoole_server->finish()方法将任务处理的结果发送给worker进程。
     * @param $serv  swoole_websocket_server 服务对象
     * @param $task_id int  任务id
     * @param $data string  task任务处理的结果内容
     * task进程的onTask事件中没有调用finish方法或者return结果，worker进程不会触发onFinish
    执行onFinish逻辑的worker进程与下发task任务的worker进程是同一个进程
     */
    public function onFinish(swoole_server $serv,  $task_id,  $data){

        echo $data;
//        return $data;
    }
}