<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/29 0029
 * Time: 下午 6:38
 */

namespace Admin\Controller;


use Think\Controller;

/**
 * Class GoodsController
 * @var \Admin\Model\GoodsModel
 * @package Admin\Controller
 */

class GoodsController extends Controller
{

    private $_model=null;
    protected function _initialize(){
        //初始化实例
    $this->_model=D('Goods');
}
    public function index(){
        //查询数据
        //模糊查询
        $name = I('get.name');
        $cond = [];
        if($name){
            $cond['name'] = ['like','%'.$name.'%'];
        }
        //商品分类
        $goods_category_id = I('get.goods_category_id');
        if($goods_category_id){
            $cond['goods_category_id'] = $goods_category_id;
        }
        //品牌分类
        $brands_id = I('get.brands_id');
        if($brands_id){
            $cond['brands_id'] = $brands_id;
        }
        //是否是精品、热销、
        $goods_status = I('get.goods_status');
        if($goods_status){
            $cond['goods_status'] = $goods_status;
        }
        //是否上架
        $is_on_sale = I('is_on_sale');
        if(strlen($is_on_sale)){
        $cond['is_on_sale'] = $is_on_sale;
    }

        //获取商品列表
        $this->assign($this->_model->getPage($cond));

        //获取所有的商品分类
        $goods_category_model = D('GoodsCategory');
        $goods_categories     = $goods_category_model->getList();
        $this->assign('goods_categories',$goods_categories);

        //获取所有的品牌列表//取出品牌分类
        $brand_model = D('Brand');
        $brands = $brand_model->getList();
        $this->assign('brands',$brands);

        //取出商品促销状态
        $goods_statuses = [
            ['id' => 1, 'name' => '精品'],
            ['id' => 2, 'name' => '新品'],
            ['id' => 4, 'name' => '热销']
        ];
        $this->assign('goods_statuses',$goods_statuses);
        //商品是否上架
        $is_on_sales = [
            ['id' => 1, 'name' => '上架'],
            ['id' => 0, 'name' => '下架'],
        ];
        $this->assign('is_on_sales',$is_on_sales);
        $this->display();

    }
    private function _before_view() {
        //获取所有的商品分类,使用ztree展示,所以转换成json
        $goods_category_model = D('GoodsCategory');
        $goods_categories     = $goods_category_model->getList();
        $this->assign('goods_categories', json_encode($goods_categories));

        //获取所有的品牌列表
        $brand_model = D('Brand');
        $brands      = $brand_model->getList();
        $this->assign('brands', $brands);

        //获取所有的供货商列表
        $supplier_model = D('Supplier');
        $suppliers      = $supplier_model->getList();
        $this->assign('suppliers', $suppliers);
    }
    public function add() {
        if (IS_POST) {
            //收集数据
            if ($this->_model->create() === false) {
                $this->error(get_error($this->_model));
            }
            //添加商品
            var_dump($this->_model->data());

            if ($this->_model->addGoods() === false) {
                $this->error(get_error($this->_model));
            }
            $this->success('添加成功', U('index'));
        } else {
            $this->_before_view();
            $this->display('edit');
        }
    }
    public function edit($id){
        if (IS_POST) {
            if($this->_model->create() === false) {
                $this->error(get_error($this->_model));
            }
            //修改商品
            if ($this->_model->saveGoods() === false) {
                $this->error(get_error($this->_model));
            }
            $this->success('修改成功', U('index'));
        } else {
            //获取数据
            $row = $this->_model->getGoodsInfo($id);
            //传递数据
            $this->assign('row', $row);
            $this->_before_view();
            $this->display('');
        }
    }
    public function remove($id){
       // $this->startTrans();
        $GoodsModel= M('Goods');

        if($GoodsModel->delete($id)===false){
            $this->error(get_error($this->$GoodsModel));

        }
        $condintro = [
            'goods_id' => $id
        ];
        $Goods_Gallery= M('GoodsGallery');
        if($Goods_Gallery->delete($condintro)===false){
            $this->error("删除失败");

        }

        $Goods_intro= M('GoodsIntro');

        if($Goods_intro->delete($condintro)===false){
            $this->error("删除失败");

        }

       // $this->commit();


    }
    public function removeGallery($id) {
        $goods_gallery_model = M('GoodsGallery');
        if($goods_gallery_model->delete($id) ===false){
            $this->error('删除失败');
        } else{
            $this->success('删除成功');
        }
    }
}