<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>temp</title>
</head>
<body>
<h1>显示详细列表及内容</h1>
<hr>
<?php foreach ($list as $key => $val): ?>
    <b>商品名称：</b><?php echo ($val["goods_name"]); ?><br>
    <b>商品价格：</b><?php echo ($val["shop_price"]); ?><br>
    <b>商品描述：</b><?php echo ($val["goods_desc"]); ?><br>
    <hr>
<?php endforeach ?>
</body>
</html>