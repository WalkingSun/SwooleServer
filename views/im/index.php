<?php
/**
 * Created by PhpStorm.
 * User: WalkingSun
 * Date: 2019/1/23
 * Time: 10:35
 */
$websocketUrl = '192.168.33.30:91';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>vue</title>
    <style>
        *, *:before, *:after {
            box-sizing: border-box;
        }
        body, html {
            height: 100%;
            overflow: hidden;
        }
        body, ul {
            margin: 0;
            padding: 0;
        }
        body {
            color: #4d4d4d;
            font: 14px/1.4em 'Helvetica Neue', Helvetica, 'Microsoft Yahei', Arial, sans-serif;
            background: #f5f5f5 url('dist/images/bg.jpg') no-repeat center;
            background-size: cover;
            font-smoothing: antialiased;
        }
        ul {
            list-style: none;
        }
        #chat {
            margin: 20px auto;
            width: 800px;
            height: 600px;
        }
    </style>
    <style type="text/css">#chat{overflow:hidden;border-radius:3px}#chat .main,#chat .sidebar{height:100%}#chat .sidebar{float:left;width:200px;color:#f4f4f4;background-color:#2e3238}#chat .main{position:relative;overflow:hidden;background-color:#eee}#chat .m-text{position:absolute;width:100%;bottom:0;left:0}#chat .m-message{height:calc(100% - 10pc)}</style><style type="text/css">.m-card{padding:9pt;border-bottom:1px solid #24272c}.m-card footer{margin-top:10px}.m-card .avatar,.m-card .name{vertical-align:middle}.m-card .avatar{border-radius:2px}.m-card .name{display:inline-block;margin:0 0 0 15px;font-size:1pc}.m-card .search{padding:0 10px;width:100%;font-size:9pt;color:#fff;height:30px;line-height:30px;border:1px solid #3a3a3a;border-radius:4px;outline:0;background-color:#26292e}</style><style type="text/css">.m-list li{padding:9pt 15px;border-bottom:1px solid #292c33;cursor:pointer;-webkit-transition:background-color .1s;transition:background-color .1s}.m-list li:hover{background-color:hsla(0,0%,100%,.03)}.m-list li.active{background-color:hsla(0,0%,100%,.1)}.m-list .avatar,.m-list .name{vertical-align:middle}.m-list .avatar{border-radius:2px}.m-list .name{display:inline-block;margin:0 0 0 15px}</style><style type="text/css">.m-text{height:10pc;border-top:1px solid #ddd}.m-text textarea{padding:10px;height:100%;width:100%;border:none;outline:0;font-family:Micrsofot Yahei;resize:none}</style><style type="text/css">.m-message{padding:10px 15px;overflow-y:scroll}.m-message li{margin-bottom:15px}.m-message .time{margin:7px 0;text-align:center}.m-message .time>span{display:inline-block;padding:0 18px;font-size:9pt;color:#fff;border-radius:2px;background-color:#dcdcdc}.m-message .avatar{float:left;margin:0 10px 0 0;border-radius:3px}.m-message .text{display:inline-block;position:relative;padding:0 10px;max-width:calc(100% - 40px);min-height:30px;line-height:2.5;font-size:9pt;text-align:left;word-break:break-all;background-color:#fafafa;border-radius:4px}.m-message .text:before{content:" ";position:absolute;top:9px;right:100%;border:6px solid transparent;border-right-color:#fafafa}.m-message .self{text-align:right}.m-message .self .avatar{float:right;margin:0 0 0 10px}.m-message .self .text{background-color:#b2e281}.m-message .self .text:before{right:inherit;left:100%;border-right-color:transparent;border-left-color:#b2e281}</style></head>

    <script type="application/javascript" src="/js/jquery.min.js"></script>
<body style="">

<div id="chat"><div class="sidebar">
        <div class="m-card">
            <header>
                <img class="avatar" width="40" height="40" alt="Coffce" src="<?php echo $user['avatar'];?>">
                <p class="name"><?php echo $user['username'];?></p>
            </header>
            <!--            <footer>-->
            <!--                <input class="search" placeholder="search user...">-->
            <!--            </footer>-->
        </div>
        <!--v-component-->
        <div class="m-list">
            <ul><!--v-for-start-->
                <?php
                if ($userList){
                    foreach ($userList as $v){
                        echo ' <li class="active">
                    <img class="avatar" width="30" height="30" alt="" src="'.$v['avatar'].'">
                    <p class="name">'.$v['username'].'</p>
                </li>';
                    }
                }
                ?>
            </ul>
        </div><!--v-component-->
    </div>
    <div class="main">
        <div class="m-message">
            <ul><!--v-for-start-->
                <li>
                    <p class="time"><span>13:42</span></p>
                    <div class="main">
                        <img class="avatar" width="30" height="30" src="https://avatars0.githubusercontent.com/u/13904719?s=400&u=63347e4bb1baa6dfbdfac9521d3ed3bb9b40ca02&v=4">
                        <div class="text">Hello，这是一个基于php+swoole构建的简单chat示例。</div>
                    </div>
                </li>
                <li>
                    <p class="time"><span>13:42</span></p>
                    <div class="main">
                        <img class="avatar" width="30" height="30" src="https://avatars0.githubusercontent.com/u/13904719?s=400&u=63347e4bb1baa6dfbdfac9521d3ed3bb9b40ca02&v=4">
                        <div class="text">项目地址: <a href="https://github.com/WalkingSun/SwooleServer" target="_blank">https://github.com/WalkingSun/SwooleServer</a></div>
                    </div>
                </li><!--v-for-end-->
            </ul>
        </div><!--v-component-->
        <div class="m-text">
            <textarea placeholder="按 Enter 发送"></textarea>
        </div><!--v-component-->
    </div>
</div>
<!--<script src="dist/vue.js"></script>-->
<!--<script src="dist/main.js"></script>-->
<?//=\yii\helpers\Html::jsFile('@web/js/jquery.min.js')?>

<script type="application/javascript">
    var ws;
    $(window).keydown(function (event) {

        // 监听 Ctrl + Enter 可全屏查看  event.ctrlKey &&
        if ( event.keyCode == 13) {
            var text = $('textarea').val();
            var myDate = new Date();

            var time = myDate.getHours()+':'+myDate.getMinutes();
            var msg = {"username":"<?php echo $user['username'];?>","avatar":"<?php echo $user['avatar'];?>","data":text,"token":"simplechat","time":time};
            showdata(msg);
            msg = JSON.stringify(msg);

            // 优化，服务关闭 重连操作
            if(  "undefined" == typeof(ws) || null == ws ){
                im();
            }else{
                ws.send(msg);
            }
        }
    });

    function im(){
        ws = new WebSocket("ws://<?php echo $websocketUrl;?>");

        ws.onopen = function()
        {
            var msg = {"username":"<?php echo $user['username'];?>","avatar":"<?php echo $user['avatar'];?>","token":"simplechat_open"};
            msg = JSON.stringify(msg);
            ws.send(msg);
        };

        ws.onmessage = function(evt)
        {
            var d = JSON.parse(evt.data);
            if( d.action=='connect' ){
                var li = '<li class="active" id="user_'+d.fd+'">' +
                    '<img class="avatar" width="30" height="30" alt="" src="'+d.avatar+'">' +
                    '<p class="name">'+d.username+'</p>' +
                    '</li>';
                $(".m-list ul").append(li);
            }
            if( d.action=='send' ) {
                showdata(d);
            }

            if( d.action=='remove'){
                if( d.username!='<?php echo $user['username'];?>' ){
                    $("#user_"+d.fd).remove();
                }
            }

            console.log(evt.data)
        };

        ws.onclose = function(evt)
        {
            console.log("WebSocketClosed!");
        };

        ws.onerror = function(evt)
        {

            console.log("WebSocketError!");

        };
    }
    im();

    function showdata(data) {

        var t = '<li>' +
            '<p class="time"><span>'+data.time+'</span></p>' +
            '<div class="main">' +
            '<div ><img class="avatar" width="30" height="30" src="'+data.avatar+'">' +
            //'<span style="float:left"><?php //echo $user['username'];?>//</span></div>'
            '<div class="text">'+data.data+'</div>' +
            '</div>' +
            '</li>';
        $('textarea').val('');
        $(".m-message ul").append(t);
    }

    // setInterval(function(){ws.send('active');},60000*5)
</script>


</body>
</html>


