<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/25 0025
 * Time: 上午 9:21
 */

namespace Admin\Controller;


use Think\Controller;

class BrandController extends Controller
{
    private $_model = null ;//创建私有属性
    protected function _initialize(){//构造自定义类
        $this->_model = D('Brand');
    }
    public function index(){
        //$rows = $this->_model->select();
      //  $this->assign("rows",$rows);

        $name = I('get.name');//获取搜索数据
        $cond['status'] = ["egt",0];//显示条件

        if($name){
            $cond['name']=['like','%'.$name.'%'];//模糊查询
        }
        $data = $this->_model->getPage($cond);

        /*dump($data);
        exit;*/
        $this->assign($data);
        $this->display('index');
    }
    public  function add(){
        if(IS_POST){
            //收集数据
            if($this->_model->create() === false){
                $this->error(get_error($this->_model));
            }

            //提交数据
            if($this->_model->add() === false){
                $this->error(get_error($this->_model));
            }else{
                $this->success('添加成功',U('index'));
            }

        }else{
            $this->display();
        }
    }
    public function edit($id){
        if(IS_POST){
            if($this->_model->create() === false){
                $this->error(get_error($this->_model));
            }

            //提交数据
            if($this->_model->save() === false){
                $this->error(get_error($this->_model));
            }else{
                $this->success('修改成功',U('index'));
            }
        }else{
            $row = $this->_model->find($id);
            $this->assign('row',$row);
            $this->display('add');
        }
    }
    public function remove($id){
        $data = [
            'id' => $id,
            'status' => -1,
            'name' => ['exp','concat(name,"_del")']
        ];
       $rst =  $this->_model->setField($data);

        if($this->_model->setField($data) === false){
            $this->error(get_error($this->_model));
        }else{
            $this->success('删除成功',U('index'));
        }
    }
    public function aaa(){
    phpinfo();
}

}