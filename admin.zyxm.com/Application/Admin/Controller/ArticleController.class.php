<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/25 0025
 * Time: 下午 2:36
 */

namespace Admin\Controller;


use Think\Controller;

class ArticleController extends Controller
{   /**
     * @var /Admin/
     */
    private $_model = null;
    protected function _initialize(){
      $this->_model = D('Article');
}
    public function index(){
        $name = I('get.name');//获取搜索数据
        $cond['article.status'] = ["egt",0];
        if($name){
            $cond['article.name']=['like','%'.$name.'%'];//模糊查询
        }


        $data = $this->_model->getPage($cond);

        /*dump($data);15889460514 item
        exit;*/
        $this->assign($data);
        $this->display();
    }
    public function add(){
        if(IS_POST){
            var_dump($_POST);
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
            $ArticleCategoryModel = D("ArticleCategory");
            $rows = $ArticleCategoryModel->select();
            $this->assign("rows",$rows);
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
            $ArticleCategoryModel = D("ArticleCategory");
            $rows = $ArticleCategoryModel->select();
            $this->assign("rows",$rows);
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
        /*$rst =  $this->_model->setField($data);
        var_dump($rst);
        exit;*/
        if($this->_model->save($data) === false){
            $this->error(get_error($this->_model));
        }else{
            $this->success('删除成功',U('index'));
        }
    }

}