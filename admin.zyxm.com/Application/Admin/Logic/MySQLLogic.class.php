<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/28 0028
 * Time: 下午 4:50
 */

namespace Admin\Logic;


class MySQLLogic implements DbMysql
{

    /**
     * DB connect
     *
     * @access public
     *
     * @return resource connection link
     */
    public function connect()
    {
        echo __METHOD__;
        dump(func_get_args());
        echo "<hr />";
    }

    /**
     * Disconnect from DB
     *
     * @access public
     *
     * @return viod
     */
    public function disconnect()
    {
        echo __METHOD__;
        dump(func_get_args());
        echo "<hr />";
    }

    /**
     * Free result
     *
     * @access public
     * @param resource $result query resourse
     *
     * @return viod
     */
    public function free($result)
    {
        echo __METHOD__;
        dump(func_get_args());
        echo "<hr />";
    }

    /**
     * Execute simple query
     *
     * @access public
     * @param string $sql SQL query
     * @param array $args query arguments
     *
     * @return resource|bool query result
     */
    public function query($sql, array $args = array())
    {
        //有可能是查询语句，所以如果是查询，就输出一些信息
        if (strpos('SELECT', $sql) !== false) {
            echo __METHOD__;
            dump(func_get_args());
            echo '<hr />';
        }

        //获取所有的实参
        $args   = func_get_args();
        //获取sql语句
        $sql    = array_shift($args);
        //将sql语句分隔
        $params = preg_split('/\?[NFT]/', $sql);
        //删除最后一个空元素
        array_pop($params);
        //sql变量已经没用了， 我们用来拼凑完整的sql语句
        $sql    = '';
        foreach ($params as $key => $value) {
            $sql .= $value . $args[$key];
        }
        //执行一个写操作
        return M()->execute($sql);
    }

    /**
     * Insert query method
     *
     * @access public
     * @param string $sql SQL query
     * @param array $args query arguments
     *
     * @return int|false last insert id
     */
    public function insert($sql, array $args = array())
    {
        //获取所有的实参
        $args       = func_get_args();
        var_dump($args);
        $sql        = $args[0];
        $table_name = $args[1];
        $params     = $args[2];
        $sql        = str_replace('?T', $table_name, $sql);
        $tmp        = [];
        foreach ($params as $key => $value) {
            $tmp[] = $key . '="' . $value . '"';
        }
        $sql = str_replace('?%', implode(',', $tmp), $sql);
        var_dump($sql);
        if (M()->execute($sql) !== false) {
            return M()->getLastInsID();
        } else {
            return false;
        }
    }

    /**
     * Update query method
     *
     * @access public
     * @param string $sql SQL query
     * @param array $args query arguments
     *
     * @return int|false affected rows
     */
    public function update($sql, array $args = array())
    {
        echo __METHOD__;
        dump(func_get_args());
        echo "<hr />";
    }

    /**
     * Get all query result rows as associated array
     *
     * @access public
     * @param string $sql SQL query
     * @param array $args query arguments
     *
     * @return array associated data array (two level array)
     */
    public function getAll($sql, array $args = array())
    {
        echo __METHOD__;
        dump(func_get_args());
        echo "<hr />";
    }

    /**
     * Get all query result rows as associated array with first field as row key
     *
     * @access public
     * @param string $sql SQL query
     * @param array $args query arguments
     *
     * @return array associated data array (two level array)
     */
    public function getAssoc($sql, array $args = array())
    {
        echo __METHOD__;
        dump(func_get_args());
        echo "<hr />";
    }

    /**
     * Get only first row from query
     *
     * @access public
     * @param string $sql SQL query
     * @param array $args query arguments
     *
     * @return array associated data array
     *///获取一行数据
    public function getRow($sql, array $args = array())
    {
        $args = func_get_args();//获取所有实参
        $sql = array_shift($args);//获取SQL 语句
        //将SQL 进行分割
        $params = preg_split('/\?[NFT]/',$sql);
        array_pop($params);

        $sql='';
        foreach($params as $key=>$value){
            $sql .= $value.$args[$key];
        }
        $rows = M()->query($sql);
        return array_shift($rows);
    }

    /**
     * Get first column of query result
     *
     * @access public
     * @param string $sql SQL query
     * @param array $args query arguments
     *
     * @return array one level data array
     */
    public function getCol($sql, array $args = array())
    {
        echo __METHOD__;
        dump(func_get_args());
        echo "<hr />";
    }

    /**
     * Get one first field value from query result
     *
     * @access public
     * @param string $sql SQL query
     * @param array $args query arguments
     *
     * @return string field value
     */
    public function getOne($sql, array $args = array())
    {
        //获取所有的实参
        $args   = func_get_args();
        //获取sql语句
        $sql    = array_shift($args);
        //将sql语句分隔
        $params = preg_split('/\?[NFT]/', $sql);
        //删除最后一个空元素
        array_pop($params);
        //sql变量已经没用了， 我们用来拼凑完整的sql语句
        $sql    = '';
        foreach ($params as $key => $value) {
            $sql .= $value . $args[$key];
        }
        //query返回一个二维数组
        $rows = M()->query($sql);
        //获取第一行
        $row  = array_shift($rows);
        //获取第一个字段值
        return array_shift($row);
    }
}