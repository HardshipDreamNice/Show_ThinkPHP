<?php if (!defined('THINK_PATH')) exit();?><table>
<?php
 foreach ($attrdata as $v) { if ($v['attr_type'] == 0) { if ($v['attr_input_type'] == 0) { echo "<tr><td>".$v['attr_name']."：</td>"; echo "<td><input type='text' name='attr[".$v['id']."]' /></td></tr>"; }else{ $attrvalues = str_replace('，',',',$v['attr_value']); echo "<tr><td><a href='javascript:;'>[+]</a>".$v['attr_name']."：</td><td><select name='attr[".$v['id']."]'>"; $attrs = explode(',',$attrvalues); foreach ($attrs as $v1) { echo "<option value='".$v1."'>".$v1."</option>"; } echo "</select><td></tr>"; } }else{ if ($v['attr_input_type'] == 0) { echo "<tr><td>".$v['attr_name']."：</td>"; echo "<td><input type='text' name='' /></td></tr>"; }else{ $attrvalues = str_replace('，',',',$v['attr_value']); echo "<tr><td><a href='javascript:;' onclick='copythis(this)'>[+]</a>".$v['attr_name']."：</td><td><select name='attr[".$v['id']."][]'>"; $attrs = explode(',',$attrvalues); foreach ($attrs as $v1) { echo "<option value='".$v1."'>".$v1."</option>"; } echo "</select><td></tr>"; } } } ?>
</table>
<script>
function copythis(o){
    // 取出当前行
    var _trs = $(o).parent().parent();
    // 判断当前A标签中的内容
    if ($(o).html() == '[+]') {
        // 克隆
        var _new_trs = _trs.clone();
        // 把新行里面的加号改成[-]
        _new_trs.find('a').html('[-]');
        // 追加DOM
        _trs.after(_new_trs);
    }else{
        // 删除
        _trs.remove();
    }
}
</script>