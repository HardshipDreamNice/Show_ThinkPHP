<?php
namespace Admin\Model;

Class TypeModel extends \Think\Model
{
    // 字段
    protected $fields = array(
        'id',
        'type_name',
        '_pk' => 'id'
    );

    // 数据验证
    protected $_validate = array(
        array('type_name', 'require', '必须填写商品类型')
    );

    // 表单白名单
    protected $insertFields = array(
        'type_name'
    );
}

?>
