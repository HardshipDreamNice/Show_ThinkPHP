<?php
namespace Admin\Controller;
use Think\Controller;

class CategoryController extends Controller
{
    // 商品类型添加
    public function add()
    {
        $CateModel = D('Category');
        if (IS_POST) {
            if ($CateModel->create(I('post.', 1))) {
                if (isset($CateModel->id)) {
                    unset($CateModel->id);
                }

                // 增加商品类型
                if ($CateModel->add()) {
                    $this->success('新增成功', U('lst'));
                    exit;
                } else {
                    $this->error('新增失败，请联系管理员');
                }
            } else {
                // 输出错误信息
                $this->error($CateModel->getError());
            }
        }
        // 无限极分类
        $this->catedata = $catedata = $CateModel->getTree();
        // 取出商品栏目
        $this->display();
    }

    // 显示商品栏目
    public function lst()
    {
        $cateModel = D('Category');
        $this->catedata = $cateModel->getTree();
        $this->display();
    }

    // 数据编辑
    public function edt()
    {
        $cateModel = D('Category');
        if (IS_POST) {  // 用户提交修改操作
            // 提交的父级栏目ID是否是自己的子孙ID
            $pid = I('post.parent_id');
            $eid = I('post.id'); // 自己的ID
            $ids = $cateModel->getChild($eid);  // 返回子孙栏目的ID
            $ids[] = $eid; // 将自己添加至该数组中

            // 判断父类ID是否在ids中出现
            if (in_array($pid, $ids)) {
                $this->error('不允许把自己的子孙栏目当成父类栏目');
            }

            // 完成修改
            if ($cateModel->create(I('post.', 2))) {
                if ($cateModel->save() !== false) {
                    $this->success('修改成功', U('lst'));
                    exit;
                } else {
                    $this->error('修改失败，请联系管理员');
                }
            } else {
                $this->error($cateModel->getError());
            }
        }


        $eid = I('get.id') + 0;

        $this->list = $list = $cateModel->where("id = {$eid}")->find();

        // 无限极分类
        $this->catedata = $catedata = $cateModel->getTree();

        // 修改时 不显示自己及子孙栏目
        $ids = $cateModel->getChild($eid);  // 返回子孙栏目的ID
        $ids[] = $eid; // 将自己添加至该数组中
        $this->assign('ids', $ids); // 用于前台比对
        $this->display();
    }

    // 数据删除
    public function del()
    {
        $did = I('get.id') + 0;
        $cateModel = D('Category');
        $list = $cateModel->where("parent_id = {$did}")->count();

        if (empty($list)) {
            if ($cateModel->delete($did)) {
                $this->success('删除成功', U('lst'));
                exit;
            } else {
                $this->error('删除失败，请联系管理员...');
            }
        } else {
            $this->error('删除失败，请先删除该分类下的子分类');
        }
    }
}

?>
