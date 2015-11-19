<?php
namespace Home\Controller;

use Think\Controller;

class IndexController extends Controller
{
    public function index()
    {
        // 跨模块取出导航
        $cateModel = D('Admin/Category');
        $navdata = $cateModel->getNav();
        $this->assign('navdata',$navdata);

        // 取出栏目信息
        $catedata = $cateModel->getTree();
        $this->assign('catedata',$catedata);

        // 热卖
        $goodsModel = D("Admin/Goods");
        $this->hotdata = $goodsModel->getByGoods('is_hot', 3);
        // 精品
        $this->bestdata = $goodsModel->getByGoods('is_best', 3);
        // 新品
        $this->newdata = $goodsModel->getByGoods('is_new', 3);
        $this->display();
    }

    // 栏目页面方法
    public function category()
    {
        // 跨模块取出导航
        $cateModel = D('Admin/Category');
        $navdata = $cateModel->getNav();
        $this->assign('navdata',$navdata);

        // 取出栏目信息
        $catedata = $cateModel->getTree();
        $this->assign('catedata',$catedata);

        // 接收栏目ID
        $cat_id = I('get.cat_id') + 0;
        // 查出当前栏目的子孙ID
        $ids = $cateModel->getChild($cat_id);
        if (empty($ids)) {
            // 没有数据
            $ids[] = $cat_id;
        }
        $goodsModel = D('Admin/Goods');
        $ids = implode(',',$ids);
        $goodsdata = $goodsModel->where("cat_id in ($ids)")->select();
        if (empty($goodsdata)) {
            // 商品不存在时 重定向至首页
            header("Location:/index.php");
        }
        $this->assign('goodsdata',$goodsdata);
        $this->display();
    }
}
