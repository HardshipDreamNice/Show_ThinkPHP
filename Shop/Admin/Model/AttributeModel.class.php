<?php
namespace Admin\Model;

Class AttributeModel extends \Think\Model
{
    // 字段
    protected $fields = array(
        'id',
        'attr_name',
        'type_id',
        'attr_type',
        'attr_input_type',
        'attr_value',
        '_pk' => 'id'
    );

    // 数据验证
    protected $_validate = array(
        array('attr_name', 'require', '必须属性名称'),
        array('type_id', 'number', '必须填写商品类型', 1),
        array('attr_type', array(0, 1), '属性类型不合法', 1, 'in'),
        array('attr_input_type', array(0, 1), '属性录入方式不合法', 1, 'in')
    );

    // 表单白名单
    protected $insertFields = array(
        'attr_name',
        'type_id',
        'attr_type',
        'attr_input_type',
        'attr_value',
    );

    // 根据typeid取出商品属性
    public function getAttrs($typeid){
       return $this->where("type_id = {$typeid}")->select();
    }
}
?>
