<?php
/**
 * Created by PhpStorm.
 * User: WalkingSun
 * Date: 2019/1/22
 * Time: 15:52
 */

include_once __DIR__.'/BaseController.php';
class ImController extends BaseController
{
    public $username;
    public $avatar;
    private $SERVER_SWOOLE;

    public function  init(){

        $this->SERVER_SWOOLE = $_SERVER['SERVER_SWOOLE'];

        $this->username = [
            'Tom','Tony','Jack','Sun','Waston'
        ];
        $this->avatar = [
            'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1546955641220&di=61f4a5026c126c1cd2ae73f7cb871b63&imgtype=0&src=http%3A%2F%2Fshihuo.hupucdn.com%2Fucditor%2F20160729%2F600x600_762052ca199e8eda86ccc2bd721cb183.jpeg%3FimageView2%2F2%2Fw%2F700%2Finterlace%2F1',
            'https://ss1.bdstatic.com/70cFuXSh_Q1YnxGkpoWK1HF6hhy/it/u=433888286,665156829&fm=26&gp=0.jpg',
            'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1547126106731&di=09455497ef9243a1e2d05df27bce3ef1&imgtype=0&src=http%3A%2F%2Fimg3.duitang.com%2Fuploads%2Fitem%2F201605%2F04%2F20160504174806_hNcXw.thumb.700_0.jpeg',
            'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1547126106729&di=5c659d9cf3a967165d956868d09700ce&imgtype=0&src=http%3A%2F%2Fb-ssl.duitang.com%2Fuploads%2Fitem%2F201603%2F11%2F20160311213223_RVhst.jpeg',
            'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1547126106728&di=d52f24763eff51e7e1ffc178402f80fe&imgtype=0&src=http%3A%2F%2Fb-ssl.duitang.com%2Fuploads%2Fitem%2F201406%2F29%2F20140629141935_GPCNS.thumb.700_0.jpeg',
            'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1547126106727&di=5eae31f56c61bd281154bfc49bb1abeb&imgtype=0&src=http%3A%2F%2Fb-ssl.duitang.com%2Fuploads%2Fitem%2F201510%2F12%2F20151012190907_heVuB.jpeg',
            'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1547126106727&di=abfaae5047da7f0fb0797525ac40c679&imgtype=0&src=http%3A%2F%2Fb-ssl.duitang.com%2Fuploads%2Fitem%2F201612%2F06%2F20161206231406_NQtur.jpeg',
            'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1547126106722&di=fae49fea6d267f7ca069c7ace8c06cbc&imgtype=0&src=http%3A%2F%2Fimg5q.duitang.com%2Fuploads%2Fitem%2F201405%2F12%2F20140512210610_GfQ3G.thumb.700_0.jpeg',
            'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1547126323594&di=f1ac1793fd40fe387f9881160f7bf9d6&imgtype=0&src=http%3A%2F%2Fb-ssl.duitang.com%2Fuploads%2Fitem%2F201412%2F05%2F20141205231228_FKA4U.jpeg',
        ];
    }

    public function actionIndex(){
        //查询当前服务连接所有客户信息
        $userList = [];
        if(  SwooleController::$table->count() ){
            foreach (SwooleController::$table as $v){
                $userList[] = $v;
            }
        }

        //生成当前用户信息
        $user = [
            'username'   =>   $this->username[rand(0,count($this->username)-1)].rand(10,100),
            'avatar'   =>   $this->avatar[rand(0,count($this->avatar)-1)],
        ];

        return $this->render('index',['user'=>$user,'userList'=>$userList]);
    }


}