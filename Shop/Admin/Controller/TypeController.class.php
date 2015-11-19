<?php
namespace Admin\Controller;
use Think\Controller;

/**
 * 类型控制器
 */
class TypeController extends Controller
{
    // 数据商品
    public function add()
    {
        if (IS_POST) {
            // 实例化model
            $typeModel = D("Type");

            // 构造数据对象
            if ($typeModel->create(I('post.', 1))) {

                // 移除id字段
                if (isset($typeModel->id)) {
                    // 移除
                    unset($typeModel->id);
                }

                if ($typeModel->add()) {
                    $this->success('添加商品类型成功！', U('lst'));
                    exit;
                } else {
                    $this->error('添加失败，请联系管理员');
                }
            } else {
                // 验证失败 获取错误提示
                $this->error($typeModel->getError());
            }
        }
        $this->display();
    }

    // 商品类型列表页面
    public function lst()
    {
        $typeModel = D("Type");

        // 等同：$this->assign('typedata',$typeModel);
        $this->typedata = $typeModel->select();

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
