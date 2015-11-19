<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>ECSHOP 管理中心 - 商品列表 </title>
    <meta name="robots" c>
    <meta http-equiv="Content-Type" c />
    <link href="/Public/Admin/styles/general.css" rel="stylesheet" type="text/css" />
    <link href="/Public/Admin/styles/main.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="/Public/css/page.css" />
</head>

<body>
    <h1>
<span class="action-span"><a href="goodsadd.html">添加新商品</a></span>
<span class="action-span1"><a href="#">ECSHOP 管理中心</a> </span><span id="search_id" class="action-span1"> - 商品列表 </span>
<div style="clear:both"></div>
</h1>
    <div class="form-div">
        <form action="" name="searchForm">
            <img src="/Public/Admin/images/icon_search.gif" width="26" height="22" border="0" alt="SEARCH" />
            商品价格
            <input type="text" name="keyword" size="15" />
            关键字
            <input type="text" name="keyword" size="15" />
            <input type="submit" value=" 搜索 " class="button" />
        </form>
    </div>
    <form method="post" action="" name="listForm">
        <div class="list-div" id="listDiv">
            <table cellpadding="3" cellspacing="1">
                <tr>
                    <th>
                        <input onclick='listTable.selectAll(this, "checkboxes")' type="checkbox" />
                        <a href="#">编号</a><img src="/Public/Admin/images/sort_desc.gif" /> </th>
                    <th><a href="#">商品名称</a></th>
                    <th><a href="#">价格</a></th>
                    <th><a href="#">市场价</a></th>
                    <th><a href="#">库存</a></th>
                    <th><a href="#">上架</a></th>
                    <th><a href="#">状态</a></th>
                    <th>操作</th>
                </tr>

                <?php foreach ($list as $key => $val): ?>
                <tr>
                    <td>
                        <input type="checkbox" name="checkboxes[]" value="<?php echo ($val["id"]); ?>" /><?php echo ($key+1); ?></td>
                    <td class="first-cell" style=""><span><?php echo ($val["goods_name"]); ?></span></td>
                    <td align="right"><span><?php echo ($val["shop_price"]); ?></span></td>
                    <td align="right"><span><?php echo ($val["market_price"]); ?></span></td>
                    <td align="right"><span><?php echo ($val["goods_number"]); ?></span></td>
                    <td align="center">
                        <?php if($val["is_sale"] == 1): ?><img src="/Public/Admin/images/yes.gif" />
                            <?php else: ?>
                            <img src="/Public/Admin/images/no.gif" /><?php endif; ?>
                    </td>
                    <td align="center">
                        <?php if($val["is_delete"] == 0): ?><img src="/Public/Admin/images/yes.gif" />
                            <?php else: ?>
                            <img src="/Public/Admin/images/no.gif" /><?php endif; ?>
                    </td>
                    <td align="center">
                        <a href="__URL/list" target="_blank" title="查看"><img src="/Public/Admin/images/icon_view.gif" width="16" height="16" border="0" /></a>
                        <a href="/index.php/Admin/Goods/edt/eid/<?php echo ($val["id"]); ?>" title="编辑"><img src="/Public/Admin/images/icon_edit.gif" width="16" height="16" border="0" /></a>
                        <a href="/index.php/Admin/Goods/del/did/<?php echo ($val["id"]); ?>" title="回收站" onclick="return confirm('确定加入回收站？')"><img src="/Public/Admin/images/icon_trash.gif" width="16" height="16" border="0" /></a>
                        <a href="#" title="货品列表"><img src="/Public/Admin/images/icon_docs.gif" width="16" height="16" border="0" /></a>
                    </td>
                </tr>
                <?php endforeach ?>
            </table>
            <table id="page-table" cellspacing="0">
                <tr>
                    <td align="right" nowrap="true">
                        <div class="manu">
                            <?php echo ($page); ?>
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

</html>