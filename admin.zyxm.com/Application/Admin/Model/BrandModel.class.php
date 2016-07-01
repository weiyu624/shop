<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/25 0025
 * Time: 上午 9:53
 */

namespace Admin\Model;


use Think\Model;
use Think\Page;

class BrandModel extends Model
{
    public function getPage(array $cond = []){
//        $page_setting = C('PAGE_SETTING'); //获取分页配置
        $count = $this->where($cond)->count();//获取总条数

        $page = new Page($count,2,['nocache'=>NOW_TIME]);//总行数AND 每页显示行数
        $page_html = $page->show();//分页显示
//        var_dump($page_html);
        //var_dump($page_html);
      //  $rows= $this->select();
       $rows = $this->where($cond)->page(I('get.p', 1), 2)->select();
        return [
            'rows'=>$rows,
            'page_html'=>$page_html,
        ];
    }
    /**
     * name 必填，不能重复
     * status 可选值0-1
     * sort 必须是数字
     * @var type
     */
    protected $patchValidate = true;//开启批量验证
    /**
     * name 必填，不能重复
     * status 可选值0-1
     * sort 必须是数字
     * @var type
     */
    protected $_validate = [
        ['name', 'require', '品牌商名称不能为空'],
        ['name', '', '品牌已存在', self::EXISTS_VALIDATE, 'unique'],
        ['status', '0,1', '品牌状态不合法', self::EXISTS_VALIDATE, 'in'],
        ['sort', 'number', '排序必须为数字'],
    ];
    public function getList() {
        return $this->where(['status'=>['gt',0]])->select();
    }

}