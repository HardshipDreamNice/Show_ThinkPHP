<?php
namespace Home\Model;
Class IndexModel extends \Think\Model {
    // 表字段
    protected $fields = array(
        'id',
    );

    // 数据验证
    protected $_validate = array(
        // array('newname','require','必须填写商品类型')
    );

    // 表单白名单
    protected $insertFields = array(
        // 'newname'
    );
}
 ?>
