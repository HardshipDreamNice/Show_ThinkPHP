<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>ECSHOP 管理中心 - 商品列表 </title>
    <meta name="robots" c>
    <meta http-equiv="Content-Type" c />
    <link href="/Public/Admin/styles/general.css" rel="stylesheet" type="text/css" />
    <link href="/Public/Admin/styles/main.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="/Public/CSS/page.css" />
    <script src="/Public/Admin/js/jquery-1.7.2.min.js"></script>
</head>

<body>
    <h1>
<span class="action-span"><a href="<?php echo U('Attribute/add'); ?>">添加属性</a></span>
<span class="action-span1"><a href="#">ECSHOP 管理中心</a> </span><span id="search_id" class="action-span1"> - 商品列表 </span>
<div style="clear:both"></div>
</h1>
    <div class="form-div">
        <form action="/index.php/Admin/Attribute/lst" name="searchForm" method="get">
            <img src="/Public/Admin/images/icon_search.gif" width="26" height="22" border="0" alt="SEARCH" />按商品类型显示:
            <select name="id">
                <option value="0">所有商品类型</option>
                <?php foreach($typedata as $v){ if ($v['id'] == $type_id) { $sel = "selected='selected'"; }else{ $sel=''; } ?>
                <option <?php echo $sel; ?> value="
                    <?php echo $v['id']?>">
                        <?php echo $v['type_name']?>
                </option>
                <?php } ?>
            </select>
        </form>
    </div>
    <form method="post" action="" name="listForm">
        <div class="list-div" id="listDiv">
            <table cellpadding="3" cellspacing="1">
                <tr>
                    <th>
                        <input onclick='listTable.selectAll(this, "checkboxes")' type="checkbox" />
                        <a href="#">编号</a><img src="/Public/Admin/images/sort_desc.gif" />
                    </th>
                    <th><a href="#">属性名称</a></th>
                    <th><a href="#">商品类型</a></th>
                    <th><a href="#">属性的类型</a></th>
                    <th><a href="#">属性值录入方式</a></th>
                    <th><a href="#">可选值列表</a></th>
                    <th>操作</th>
                </tr>
                <?php foreach($attrdata as $v){?>
                    <tr>
                        <td>
                            <input type="checkbox" name="checkboxes[]" value="32" />1</td>
                        <td class="first-cell" style=""><span><?php echo $v['attr_name']?></span></td>
                        <td><span><?php echo $v['type_name']?></span></td>
                        <td align="right"><span><?php echo $v['attr_type']==0?'唯一属性':'单选属性'?></span></td>
                        <td align="center">
                            <?php echo $v['attr_input_type']==0?'手工录入':'列表选择'?>
                        </td>
                        <td align="center">
                            <?php echo $v['attr_value']?>
                        </td>
                        <td align="center">
                            <a href="#" target="_blank" title="查看"><img src="/Public/Admin/images/icon_view.gif" width="16" height="16" border="0" /></a>
                            <a href="#" title="货品列表"><img src="/Public/Admin/images/icon_docs.gif" width="16" height="16" border="0" /></a>
                        </td>
                    </tr>
                    <?php }?>
            </table>
            <table id="page-table" cellspacing="0">
                <tr>
                    <td align="right" nowrap="true">
                      <div class="manu">
                        <?php echo $page; ?>
                      </div>
                    </td>
                </tr>
            </table>
        </div>
    </form>
    <div id="footer">
        共执行 7 个查询，用时 0.112141 秒，Gzip 已禁用，内存占用 3.085 MB
        <br /> 版权所有 &copy; 2005-2010 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
<script type="text/javascript">
//  完成表单的提交
$(function() {
    $("select[name=id]").change(function() {
        $("form[name=searchForm]").submit();
    });
});
</script>

</html>