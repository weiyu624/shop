<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/1 0001
 * Time: 下午 10:25
 */

namespace Admin\Model;


use Think\Model;

class PermissionModel extends Model
{
    protected $_validate =[
        ['name','require','权限名称不能为空']
    ];
    public function getList() {
        return $this->where(['status' => 1])->order('lft')->select();
    }
    //添加数据
    public function addPermission() {
        unset($this->data[$this->getPk()]);
        //创建orm
        $orm        = D('MySQL', 'Logic');
        //创建nestedsets对象
        $nestedsets = new \Admin\Logic\NestedSets($orm, $this->getTableName(), 'lft', 'rght', 'parent_id', 'id', 'level');
        if ($nestedsets->insert($this->data['parent_id'], $this->data, 'bottom') === false) {
            $this->error = '添加失败';
            return false;
        }
        return true;
    }
    public function savePermission($id){
        $parent_id = $this->getFieldById($id,'parent_id');
        if($parent_id!=$this->data('parent_id')){
            //创建orm
            $orm        = D('MySQL', 'Logic');
            //创建nestedsets对象
            $nestedsets = new \Admin\Logic\NestedSets($orm, $this->getTableName(), 'lft', 'rght', 'parent_id', 'id', 'level');
            if ($nestedsets->insert($id, $this->data['parent_id'], 'bottom') === false) {
                $this->error = '添加失败';
                return false;
            }
        }
        return $this->save();
    }
   /* public function savePermission() {
        //判断是否修改了父级权限
        $parent_id = $this->getFieldById($this->data['id'], 'parent_id');
        if ($parent_id != $this->data['parent_id']) {
            //创建orm
            $orm        = D('MySQL', 'Logic');
            //创建nestedsets对象
            $nestedsets = new \Admin\Logic\NestedSets($orm, $this->getTableName(), 'lft', 'rght', 'parent_id', 'id', 'level');
            if ($nestedsets->moveUnder($this->data['id'], $this->data['parent_id'], 'bottom') === false) {
                $this->error = '不能将分类移动到自身或后代分类中';
                return false;
            }
        }
        //保存基本数据
        return $this->save();
    }*/

}