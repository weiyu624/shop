<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/24 0024
 * Time: ���� 7:01
 */

namespace Admin\Model;


use Think\Model;

class SupplierModel extends Model
{
    protected $patchValidate = true;//开启批量验证
    /**
     * name 必填，不能重复
     * status 可选值0-1
     * sort 必须是数字
     * @var type
     */
    protected $_validate = [
        ['name', 'require', '供货商名称不能为空'],
        ['name', '', '供货商已存在', self::EXISTS_VALIDATE, 'unique'],
        ['status', '0,1', '供货商状态不合法', self::EXISTS_VALIDATE, 'in'],
        ['sort', 'number', '排序必须为数字'],
    ];

    /**
     * 获取分页数据和分页代码。
     * @param array $cond 查询条件。
     */
    public function getPageResult(array $cond = [])
    {
        //获取分页代码
        //获取分页配置
        $page_setting = C('PAGE_SETTING');
        //获取总行数
        $count = $this->where($cond)->count();

        $page = new \Think\Page($count, $page_setting['PAGE_SIZE']);
        //更改page样式

     $page->setConfig('theme', '%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
       // $page->setConfig('theme', $page_setting['PAGE_THEME']);
        $page_html = $page->show();
//      dump($page_html);
        //获取分页数据
//      $rows = $this->where($cond)->page(I('get.p',1),2)->select();
        $rows = $this->where($cond)->page(I('get.p', 1), $page_setting['PAGE_SIZE'])->select();
       // var_dump($rows);
   // dump($rows);
        //返回
        //return compact(['rows', 'page_html']);
            return [
          'rows'=>$rows,
           'page_html'=>$page_html,
       ];
    }
    public function getList() {
        return $this->where(['status'=>['gt',0]])->select();
    }
}