<?php if (!defined('THINK_PATH')) exit();?><!-- $Id: brand_info.htm 14216 2008-03-10 02:27:21Z testyang $ -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>ECSHOP 管理中心 - 添加权限 </title>
    <meta name="robots" content="noindex, nofollow"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="http://www.zyxm.com/Public/Admin/css/general.css" rel="stylesheet" type="text/css" />
    <link href="http://www.zyxm.com/Public/Admin/css/main.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="http://www.zyxm.com/Public/ext/ztree/css/zTreeStyle/zTreeStyle.css" type="text/css"/>
    <style type="text/css">
        ul.ztree{
            margin-top: 10px;
            border: 1px solid #617775;
            background: #f0f6e4;
            width: 220px;
            overflow-y: scroll;
            overflow-x: auto;
        }
    </style>

</head>
<body>
<h1>
    <span class="action-span"><a href="<?php echo U('index');?>">商品权限</a></span>
    <span class="action-span1"><a href="#">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 添加权限 </span>
    <div style="clear:both"></div>
</h1>
<div class="main-div">
    <form method="post" action="<?php echo U();?>" enctype="multipart/form-data" >
        <table cellspacing="1" cellpadding="3" width="100%">
            <tr>
                <td class="label">权限名称</td>
                <td>
                    <input type="text" name="name" maxlength="60" value="<?php echo ($row["name"]); ?>" />
                    <span class="require-field">*</span>
                </td>
            </tr>
            <tr>
                <td class="label">权限地址</td>
                <td>
                    <input type="text" name="path" maxlength="60" size="40" value="<?php echo ($row["path"]); ?>" />
                </td>
            </tr>
            <tr>
                <td class="label">父级权限</td>
                <td>
                    <input type='hidden' name="parent_id" id='permission_id'/>
                    <input type='text' disabled='disabled' id='permission_name'/>
                    <ul id='pemission-ztree' class="ztree"></ul>
                </td>
            </tr>
            <tr>
                <td class="label">描述</td>
                <td>
                    <textarea name='intro' style='resize:none;width: 40em;height: 5em;'><?php echo ($row["intro"]); ?></textarea>
                </td>
            </tr>
            <tr>
                <td class="label">排序</td>
                <td>
                    <input type="text" name="sort" maxlength="40" size="15" value="<?php echo ((isset($row["sort"]) && ($row["sort"] !== ""))?($row["sort"]):50); ?>" />
                </td>
            </tr>
            <tr>
                <td class="label">是否显示</td>
                <td>
                    <input type="radio" name="status" value="1" class='status'/> 是
                    <input type="radio" name="status" value="0" class='status' /> 否
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center"><br />
                    <input type="hidden" name="id" value="<?php echo ($row["id"]); ?>" />
                    <input type="submit" class="button" value=" 确定 " />
                    <input type="reset" class="button" value=" 重置 " />
                </td>
            </tr>
        </table>
    </form>
</div>


<div id="footer">
共执行 1 个查询，用时 0.018952 秒，Gzip 已禁用，内存占用 2.197 MB<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。
</div>
<script type="text/javascript" src="http://www.zyxm.com/Public/Admin/js/jquery.min.js"></script>
<script type="text/javascript" src="http://www.zyxm.com/Public/ext/ztree/js/jquery.ztree.core.js"></script>
<script type='text/javascript'>
    var setting = {
        data: {
            simpleData: {
                enable: true,
                idKey: "id",
                pIdKey: "parent_id",
                rootPId: 0
            }
        },
        callback: {
            onClick: function (event, ztree_obj, node) {
                $('#permission_id').val(node.id);
                $('#permission_name').val(node.name);
            },
        },
    };

    //节点数据
    var permissions = <?php echo ($permissions); ?>;

    //初始化ztree
    var permissions_ztree = $.fn.zTree.init($("#pemission-ztree"), setting, permissions);

    //展开所有的节点
    permissions_ztree.expandAll(true);



    //////////////////////   回显数据    ////////////////////////////
    $('.status').val([<?php echo ((isset($row["status"]) && ($row["status"] !== ""))?($row["status"]):1); ?>]);
    <?php if(isset($row)): ?>//回显ztree
    //1.找到父级权限的节点
    var parent_permission_node = permissions_ztree.getNodeByParam('id', <?php echo ($row["parent_id"]); ?>);
    console.debug($('#permission_id'))
    //2.选择这个节点
    permissions_ztree.selectNode(parent_permission_node);
    //3.绑定数据
    $('#permission_id').val(parent_permission_node.id);
    $('#permission_name').val(parent_permission_node.name);<?php endif; ?>
</script>
</body>

</html>