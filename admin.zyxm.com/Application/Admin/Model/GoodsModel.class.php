<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/29 0029
 * Time: 下午 7:25
 */

namespace Admin\Model;


use Think\Model;

class GoodsModel extends Model
{

    //批量验证
    protected $patchValidate = true;
    //自动验证
    /**
     * 1. 商品名必填
     * 2. 商品分类必填
     * 3. 品牌必填
     * 4. 供货商必填
     * 5. 市场价必填,必须是货币
     * 6. 商城价格必填,必须是货币
     * 7. 库存必填,必须是数字
     * ...
     */
    protected $_validate     = [
        ['name', 'require', '商品名称不能为空'],
        ['sn', '', '货号已存在', self::VALUE_VALIDATE],
        ['goods_category_id', 'require', '商品分类不能为空'],
        ['brand_id', 'require', '品牌不能为空'],
        ['supplier_id', 'require', '供货商不能为空'],
        ['market_price', 'require', '市场价不能为空'],
        ['market_price', 'currency', '市场价不合法'],
        ['shop_price', 'require', '售价不能为空'],
        ['shop_price', 'currency', '售价不合法'],
        ['stock', 'require', '库存不能为空'],
    ];
    //自动完成
    protected $_auto         = [
        ['sn', 'createSn', self::MODEL_INSERT, 'callback'],
        ['goods_status', 'array_sum', self::MODEL_INSERT, 'function'],
        ['inputtime', NOW_TIME, self::MODEL_INSERT],
    ];
    //分页显示
    public function getPage(array $cond = []) {
        $cond         = array_merge(['status' => 1], $cond);
        //获取总条数
        $count        = $this->where($cond)->count();
        //获取分页代码

        $page_setting = C('PAGE_SETTING');
        $page         = new \Think\Page($count, $page_setting['PAGE_SIZE']);
        $page->setConfig('theme', $page_setting['PAGE_THEME']);
        $page_html    = $page->show();
        //获取分页数据
        $rows         = $this->where($cond)->page(I('get.p', 1), $page_setting['PAGE_SIZE'])->select();
        //编写模板代码
        foreach ($rows as $key => $value) {
            $value['is_best'] = $value['goods_status'] & 1 ? true : false;
            $value['is_new']  = $value['goods_status'] & 2 ? true : false;
            $value['is_hot']  = $value['goods_status'] & 4 ? true : false;
            $rows[$key] = $value;
        }
        return compact('rows', 'page_html');
    }
    public function getList() {
        return $this->where(['status'=>['egt',0]])->order('lft asc')->select();
    }

     // 判断货号并生成一个.

    protected function createSn($sn) {
        $this->startTrans();
        if ($sn) {
            return $sn;
        }
        //生成规则:SN年月日编号:SN2016/0628/00001
        //获取今天已经常见了多少个商品
        $date            = date('Ymd');
        $goods_num_model = M('GoodsDayCount');
        //`保存到数据表中
        if ($num             = $goods_num_model->getFieldByDate($date, 'count')) {
            ++$num;
            $data = ['day' => $date, 'count' => $num];
            $flag = $goods_num_model->save($data);
        } else {
            $num  = 1;
            $data = ['day' => $date, 'count' => $num];
            $flag = $goods_num_model->add($data);
        }
        if ($flag === false) {
            $this->rollback();
        }
        //2.计算SN
        $sn = 'SN' . $date . str_pad($num, 5, '0', STR_PAD_LEFT);
        return $sn;
    }



     // 添加商品,提交或者回滚.

    public function addGoods() {
        //保存基本信息
        unset($this->data[$this->getPk()]);
        if (($goods_id = $this->add()) === false) {
            $this->rollback();
            return false;
        }
        //保存详细描述

        $data              = [
            'goods_id' => $goods_id,
            'content'  => I('post.content', '', false),
        ];
        $goods_intro_model = M('GoodsIntro');
        if ($goods_intro_model->add($data) === false) {
            $this->rollback();
            return false;
        }
        //保存相册
        $goods_gallery_model = M('GoodsGallery');
        $pathes = I('post.path');
        $data = [];
        foreach($pathes as $path){
            $data[] = [
                'goods_id'=>$goods_id,
                'path'=>$path,
            ];
        }
        //相册保存失败,就回滚
        if($data && ($goods_gallery_model->addAll($data)===false)){
            $this->rollback();
            return false;
        }
        $this->commit();
        return true;
    }
    public function getGoodsInfo($id) {
        //获取商品的基本信息
        $row = $this->find($id);
        //由于在前端展示的时候,需要使用到各个状态,所以我们变成一个json对象
        $row['goods_status'];
        $tmp = [];
        if($row['goods_status']&1){
            $tmp[] = 1;
        }
        if($row['goods_status']&2){
            $tmp[] = 2;
        }
        if($row['goods_status']&4){
            $tmp[] = 4;
        }
        $row['goods_status'] = json_encode($tmp);
        unset($tmp);
        //获取商品的详细描述
        $goods_intro_model = M('GoodsIntro');
        $row['content'] = $goods_intro_model->getFieldByGoodsId($id,'content');
        //获取商品的相册
        $goods_gallery_model = M('GoodsGallery');
        $row['galleries']=$goods_gallery_model->getFieldByGoodsId($id,'id,path');
        return $row;
    }

    public function saveGoods() {
        $request_data = $this->data;
        $this->startTrans();
        //保存基本信息
        if($this->save()===false){
            $this->rollback();
            return false;
        }
        //保存详细描述
        $data              = [
            'goods_id' => $request_data['id'],
            'content'  => I('post.content', '', false),
        ];
        $goods_intro_model = M('GoodsIntro');
        if ($goods_intro_model->save($data) === false) {
            $this->rollback();
            return false;
        }
        //保存相册
        $goods_gallery_model = M('GoodsGallery');
        $pathes = I('post.path');
        $data = [];
        foreach($pathes as $path){
            $data[] = [
                'goods_id'=> $request_data['id'],
                'path'=>$path,
            ];
        }
        //相册保存失败,就回滚
        if($data && ($goods_gallery_model->addAll($data)===false)){
            $this->rollback();
            return false;
        }
        //相册保存失败,就回滚

        $this->commit();
        return true;
    }
    //删除


}