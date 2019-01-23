<?php
/**
 * Created by PhpStorm.
 * User: WalkingSun
 * Date: 2019/1/23
 * Time: 10:15
 */

class BaseController
{

    public $contorllerId;

    public function __construct()
    {
        $this->contorllerId =   strtolower( trim(get_class($this),'Controller') );
        $this->init();
    }

    public function init(){

    }

    //进入视图
    public function render( $view, $values= [] ){

        if( $values ){
            foreach ($values as $k=>$v){
                $$k = $v;
            }
        }

        return include __DIR__."/../views/{$this->contorllerId}/".$view.'.php';
    }


}