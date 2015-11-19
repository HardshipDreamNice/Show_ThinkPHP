<?php
namespace Admin\Controller;
use Think\Controller;

class GoodsController extends Controller
{
    //  添加方法
    public function add()
    {
        if (IS_POST) { // 增加
            // 实例化
            $model = D('Goods');
            // echo '<pre>';print_r(I('post.attr'));exit;
            if ($model->create(I('post.'), 1)) { // 数据验证
                if ($model->add()) { // 新增成功跳转
                    $this->success('新增成功！', U('lst'));
                    exit(); // 终止操作
                } else {
                    $this->error($error = $model->getError());
                }
            } else {
                // 输出模型的错误信息
                $error = $model->getError();
                $this->error($error);
            }
        }
        // 取出商品栏目信息
        $cateModel = D('category');
        $this->catedata = $cateModel->getTree();

        // 取出商品类型
        $typeModel = D('Type');
        $this->typedata = $typeModel->select();
        // 显示模版
        $this->display('goodsadd');
    }

    // 修改
    public function edt()
    {
        if (IS_GET) { // 修改
            $eid = I('get.eid');
            $model = D('Goods');

            if ($list = $model->find($eid)) {
                $this->assign('list', $list);
                $this->display('Goodsedt');
            } else {
                $this->error('失败！请联系管理员...');
            }
        } else if (IS_POST) {

            $model = D('Goods');

            if ($model->create(I('post.'), 2)) { // 数据验证
                if ($model->save()) { // 修改成功跳转
                    $this->success('修改成功！', U('lst'));
                    exit(); // 终止操作
                } else {
                    $this->error('修改失败，请联系管理员...');
                }
            }
        }
    }

    // 删除
    public function del()
    {
        if (IS_GET) {
            $did = I('get.did');
            $model = D('Goods');
            if ($model->where("id = {$did}")->setField('is_delete', 1)) {
                $this->success('加入回收站成功！', U('lst'));
                exit;
            } else {
                $this->error('处理失败！请联系管理员...');
            }
        }
    }

    // 列表 查询 分页 排序
    public function lst()
    {
        $model = D('Goods');

        // 查询满足要求的总记录数
        $count = $model->where(' is_delete = 0 ')->count();
        // 实例化分页类 传入总记录数和每页显示的记录数(15)
        $Page = new \Think\Page($count, 15);
        // 分页显示输出
        $show = $Page->show();

        $list = $model->where(' is_delete = 0 ')->order(' id desc ')->limit($Page->firstRow . ',' . $Page->listRows)->select();

        $this->assign('list', $list);
        $this->assign('page', $show);
        $this->display('goodslist');
    }

    // 回收站
    public function recycle()
    {
        $model = D("Goods");

        $count = $model->where(' is_delete = 1 ')->count();
        $Page = new \Think\Page($count, 15);
        // 分页显示输出
        $show = $Page->show();

        $list = $model->where(' is_delete = 1 ')->order(' id desc ')->limit($Page->firstRow . ',' . $Page->listRows)->select();

        $this->assign('list', $list);
        $this->assign('page', $show);
        $this->display('goodsrecycle');

    }

    // 还原
    public function grecycle()
    {
        $rid = I('get.rid');
        $model = D('Goods');
        if ($model->where("id = {$rid}")->setField('is_delete', 0)) {
            $this->success('还原成功！', U('recycle'));
            exit;
        } else {
            $this->error('还原失败，请联系管理员..');
        }
    }

    // 彻底删除
    public function delete()
    {
        $did = I('get.did');
        $model = D('Goods');
        if ($model->delete($did)) {
            $this->success('删除成功！', U('recycle'));
            exit;
        } else {
            $this->error('删除失败，请联系管理员');
        }
    }

    // 用于显示属性的方法
    public function showattr()
    {
       $typeid = I('get.typeid') + 0;
       $attrModel = D('Attribute');
       $this->attrdata = $attrModel->getAttrs($typeid);
       $this->display();
    }
}

?>
