<?php
/**
 * Created by PhpStorm.
 * User: WalkingSun
 * Date: 2019/1/22
 * Time: 11:03
 */


include __DIR__ . '/../models/WsServer.php';
include __DIR__ . '/../models/Common.php';
include 'BasicController.php';

class SwooleController extends BasicController{

    public $host;

    public $port;

    public $swoole_config=[];

    public static $table;


    public function actionStart(){

        $config = include __DIR__ . '/../config/console.php';

        if( isset($config['swoole']['log_file']) ) $this->swoole_config['log_file'] = $config['swoole']['log_file'];

        if( isset($config['swoole']['pid_file']) ) $this->swoole_config['pid_file'] = $config['swoole']['pid_file'];

        $this->swoole_config = array_merge(
            [
                'document_root' => $config['swoole']['document_root'],
                'enable_static_handler'     => true,
//                'daemonize'=>1,
                'worker_num'=>4,
                'max_request'=>2000,
//            'task_worker_num'=>100,
                //检查死链接  使用操作系统提供的keepalive机制来踢掉死链接
                'open_tcp_keepalive'=>1,
                'tcp_keepidle'=> 1*60,     //连接在n秒内没有数据请求，将开始对此连接进行探测
                'tcp_keepcount' => 3,       //探测的次数，超过次数后将close此连接
                'tcp_keepinterval' => 0.5*60,     //探测的间隔时间，单位秒

                //swoole实现的心跳机制，只要客户端超过一定时间没发送数据，不管这个连接是不是死链接，都会关闭这个连接
//            'heartbeat_check_interval' => 10*60,        //每m秒侦测一次心跳
//            'heartbeat_idle_time' => 30*60,            //一个TCP连接如果在n秒内未向服务器端发送数据，将会被切断
            ],$this->swoole_config
        );

        $this->host = $config['swoole']['host'];
        $this->port = $config['swoole']['port'];
        $swooleServer = new WsServer(  $this->host,$this->port,$config['swoole']['mode'],$config['swoole']['socketType'],$this->swoole_config,$config);

        //连接信息保存到swoole_table
        self::$table = new \swoole_table(10);
        self::$table->column('username',\Swoole\Table::TYPE_STRING, 10);
        self::$table->column('avatar',\Swoole\Table::TYPE_STRING, 255);
        self::$table->column('msg',\Swoole\Table::TYPE_STRING, 255);
        self::$table->column('fd',\Swoole\Table::TYPE_INT, 6);
        self::$table->create();

        $swooleServer->openCallback = function( $server , $request ){
            echo "server handshake with fd={$request->fd}\n";
        };

        $swooleServer->runApp = function( $request , $response ) use($config,$swooleServer){

            //全局变量设置及app.log
            $this->globalParam( $request );
            $_SERVER['SERVER_SWOOLE'] = $swooleServer;

            //记录日志
            $apiData = $_SERVER;
            unset($apiData['SERVER_SWOOLE']);
            Common::addLog( $config['log'] , ($apiData) );

            //解析路由
            $r = $_GET['r'];
            $r = $r?:( isset($config['defaultRoute'])?$config['defaultRoute']:'index/index');
            $params = explode('/',$r);
            $controller = __DIR__.'/../controllers/'.ucfirst($params[0]).'Controller.php';

            $result = '';
            if( file_exists( $controller ) ){
                require_once $controller;
                $class = new ReflectionClass(ucfirst($params[0]).'Controller');
                if( $class->hasMethod( 'action'.ucfirst($params[1]) ) ){
                    $instance  = $class->newInstanceArgs();
                    $method = $class->getmethod('action'.ucfirst($params[1])); // 获取类中方法
                    ob_start();
                    $method->invoke($instance);    // 执行方法
                    $result = ob_get_contents();
                    ob_clean();
                }else{
                    $result = 'NOT FOUND!';
                }
            }else{
                $result = "$controller not exist!";
            }

            $response->end( $result );
        };

        $swooleServer->workStartCallback = function( $server,  $worker_id ){

        };

        $swooleServer->taskCallback = function( $server , $request ){
            //发送通知或者短信、邮件等

        };

        $swooleServer->finishCallback = function( $serv,  $task_id,  $data ){

//            return $data;
        };

        $swooleServer->messageCallback = function( $server,  $iframe  ){
            //记录客户端信息
            echo "Client connection fd {$iframe->fd} ".PHP_EOL;

            $data = json_decode( $iframe->data ,1 );

            if( !empty($data['token']) ){
                if( $data['token']== 'simplechat_open' ){
                    if( !self::$table->exist($iframe->fd) ){
                        $user = array_merge($data,['fd'=>$iframe->fd]);
                        self::$table->set($iframe->fd,$user);

                        //发送连接用户信息
                        foreach (self::$table as $v){
                            if($v['fd']!=$iframe->fd){
                                $pushData = array_merge($user,['action'=>'connect']);
                                $server->push($v['fd'],json_encode($pushData));
                            }
                        }
                    }

                }

                if( $data['token']=='simplechat' ){
                    //查询所有连接用户，分发消息

                    foreach (self::$table as $v){
                        if($v['fd']!=$iframe->fd){
                            $pushData = ['username'=>$data['username'],'avatar'=>$data['avatar'],'time'=>date('H:i'),'data'=>$data['data'],'action'=>'send'];
                            $server->push($v['fd'],json_encode($pushData));
                        }
                    }
                }
            }

            //接受消息，对消息进行解析，发送给组内人其他人

        };

        $swooleServer->closeCallback = function(  $server,  $fd,  $reactorId ){

            if(  self::$table->exist($fd) ){
                //退出房间处理
                self::$table->del($fd);
                foreach (self::$table as $v){
                    $pushData = ['fd'=>$fd,'username'=>'','avatar'=>'','time'=>date('H:i'),'data'=>'','action'=>'remove'];
                    $server->push($v['fd'],json_encode($pushData));
                }
            }

            echo  "Client close fd {$fd}".PHP_EOL;
        };

        $this->stdout("server is running, listening {$this->host}:{$this->port}" . PHP_EOL);
        $swooleServer->run();
    }


    public function actionStop(){
        $r = $this->sendSignal( SIGTERM );
        if( $r ){
            $this->stdout("server is stopped, stop listening {$this->host}:{$this->port}" . PHP_EOL);
        }
    }

    public function actionRestart(){
        $_SERVER['SERVER_SWOOLE']->shutdown();
        $this->actionStart();
    }

    public function actionReload(){
        $this->sendSignal(SIGUSR1);
    }



}
