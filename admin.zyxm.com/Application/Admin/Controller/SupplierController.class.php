<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/24 0024
 * Time: ���� 6:56
 */

namespace Admin\Controller;
use Think\Controller;

class SupplierController extends Controller
{
    private $_model = null;

    protected function _initialize(){
        $this->_model = D('Supplier');
    }
    //��ѯSupplier������
    public function index(){
       /*   $cond['status'] = ['egt',0];
            $this->_model= D("Supplier");
            $rows = $this->_model->where($cond)->select();
            $this->assign('rows',$rows);
            $this->display();
       */

        $name = I('get.name');
        $cond['status'] = ['egt',0];
        if($name){
            $cond['name']=['like','%'.$name.'%'];
        }

        $data = $this->_model->getPageResult($cond);
        //传递数据
        $this->assign($data);
        //调用视图
        $this->display();
    }
    //�������
    public function add(){
        if(IS_POST){
            //创建模型
            $this->_model = D('Supplier');
            //收集数据
            if($this->_model->create()===false){
                $this->error(get_error($this->_model));
            }
            //保存数据
            //提示跳转
            if($this->_model->add() === false){
                $this->error(get_error($this->_model));
            }else{
                $this->success('添加成功',U('index'));
            }
        }else{
            //调用视图
            $this->display();
        }
    }
    public function edit($id) {
        if(IS_POST){
            if($this->_model->create() === false){
                $this->error(get_error($this->_model));
            }
            if($this->_model->save() === false){
                $this->error(get_error($this->_model));
            }
            $this->success('修改成功',U('index'));
        }else{
            //创建模型
            //获取数据
            $row = $this->_model->find($id);
            //展示
            $this->assign('row',$row);
            $this->display('add');
        }
    }
    public function remove($id) {
        //调用模型删除
        //跳转
        $data = [
            'id'=>$id,
            'status'=>-1,
            'name'=>['exp','concat(name,"_del")'],
        ];
        if($this->_model->setField($data) === false){
            $this->error(get_error($this->_model));
        }else{
            $this->success('删除成功',U('index'));
        }
    }
}