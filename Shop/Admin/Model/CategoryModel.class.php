<?php
namespace Admin\Model;

Class CategoryModel extends \Think\Model
{
    // 表字段
    protected $fields = array(
        'id',
        'cat_name',
        'parent_id',
        '_pk' => 'id'
    );

    // 数据验证
    protected $_validate = array(
        array('cat_name', 'require', '必须填写商品栏目名称')
        // array('parent_id','number','栏目父ID错误，请联系管理员...')
    );

    // 表单白名单
    protected $insertFields = array(
        'cat_name',
        'parent_id'
    );

    // 取出栏目数据
    public function getTree()
    {
        $arr = $this->select();
        return $this->_getTree($arr, $pid = 0, $lev = 0);
    }

    /**
     * [_getTree 递归实现无限极分类]
     * @param  [array]  $arr    [数据结果集]
     * @param  integer $parent [父ID]
     * @param  integer $level [递归次数]
     * @return [type]          [description]
     */
    public function _getTree($arr, $parent = 0, $level = 0)
    {
        // 保存结果
        static $list = array();
        foreach ($arr as $v) {
            if ($v['parent_id'] == $parent) {
                $v['lev'] = $level;
                $list[] = $v;
                $this->_getTree($arr, $v['id'], $level + 1);
            }
        }
        // 返回结果集
        return $list;
    }

    // 根据传递的ID，找到子孙ID
    public function getChild($id)
    {
        $arr = $this->select();
        return $this->_getChild($arr, $id);
    }

    // 递归方法实现
    public function _getChild($arr, $id)
    {
        static $ids = array();
        foreach ($arr as $v) {
            // 父ID等于当前ID
            if ($v['parent_id'] == $id) {
                $ids[] = $v['id'];
                $this->_getChild($arr, $v['id']);
            }
        }
        return $ids;
    }

    // 取出顶级栏目的数据
    public function getNav()
    {
        return $this->where('parent_id = 0')->select();
    }
}

?>
