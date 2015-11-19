<?php
namespace Admin\Controller;
use Think\Controller;

/**
 * 属性控制器
 */
class AttributeController extends Controller
{
    // 数据添加
    public function add()
    {
        // 写入数据
        if (IS_POST) {
            $attrModel = D('Attribute');
            if ($attrModel->create(I('post.', 1))) {
                if (isset($attrModel->id)) {
                    unset($attrModel->id);
                }

                //  接收商品类型ID 用于跳转
                $type_id = I('post.type_id');
                if ($attrModel->add()) {
                    $this->success('新增成功', U('lst', array('id' => $type_id)));
                    exit;
                } else {
                    $this->error('新增失败，请联系管理员');
                }
            } else {
                $this->error($attrModel->getError());
            }
        }

        // 取出商品类型
        $typeModel = D('Type');

        $this->typedata = $typeModel->select();

        $this->display();
    }

    // 属性列表
    public function lst()
    {
        $gid = I('get.id') + 0;

        // 判断商品类型提交的ID，为空
        if (empty($gid)) {
            $where = 1;
        } else {
            $where['type_id'] = array('eq', $gid); // type_id = $gid
        }

        // 分页
        $attrModel = D('Attribute');
        $count = $attrModel->where($where)->count();// 查询满足要求的总记录数
        $Page = new \Think\Page($count, 10);// 实例化分页类 传入总记录数和每页显示的记录数

        $attrData = $attrModel->field('a.*,b.type_name')->join("as a left join it_type as b on a.type_id = b.id ")->where($where)->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $show = $Page->show();// 分页显示输出

        $this->assign('attrdata', $attrData);
        $this->assign('page', $show);// 赋值分页输出

        // 取出商品类型
        $typeModel = D('Type');
        $this->typedata = $typeModel->select();
        // 将属性ID分配到静态页面
        $this->assign('type_id', $gid);
        $this->display();

    }

    // 数据编辑
    public function edt()
    {

    }

    // 数据删除
    public function del()
    {

    }

}

?>
