<?php
/**
 * Created by PhpStorm.
 * User: WalkingSun
 * Date: 2019/1/22
 * Time: 15:52
 */

include_once __DIR__.'/BaseController.php';
class IndexController extends BaseController
{

    public function actionIndex(){
        $result = 222;
        $this->render('index',['result'=>$result]);
    }


}