<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/25 0025
 * Time: 下午 2:59
 */

namespace Admin\Model;


use Think\Model;
use Think\Page;

class ArticleModel extends Model
{
    public function getPage(array $cond = []){
//        //$page_setting = C('PAGE_SETTING'); //获取分页配置
        $count = $this->where($cond)->count();//获取总条数
         $page = new Page($count,4,['nocache'=>NOW_TIME]);//总行数AND 每页显示行数
         $page_html = $page->show();//分页显示
//        var_dump($page_html);
        //var_dump($page_html);

       // $ArticleCategoryModel = M('ArticleCategory');
       // $rows[] = $ArticleCategoryModel->select();
        //$sql = "SELECT a.`id` AS aid ,a.`name` AS aname,ac.`name` AS acname, a.`status` AS astatus,a.`sort` as asort  FROM `article_category` AS `ac` JOIN `article` AS `a`  ON a.article_category_id = ac.id  WHERE a.`status`>=1 ORDER BY a.`id` limit 4";
        //$rows= $this->query($sql);

        $rows =$this->join('article_category  on article.article_category_id = article_category.id')->field('article.id as aid,article.name as aname,article.intro as aintro,article.`status` as `astatus`,article.`sort` as `asort`,article.inputtime as ainputtime,article_category.name as acname')->where($cond)->page(I('get.p', 1), 4)->select();

       return [
            'rows'=>$rows,
            'page_html'=>$page_html,
        ];
    }

}