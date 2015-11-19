<?php
namespace Admin\Model;
use Think\Model;

class GoodsModel extends Model
{

    // 字段
    protected $fields = array(
        'id',
        'goods_name',
        'goods_sn',
        'goods_number',
        'shop_price',
        'market_price',
        'is_hot',
        'is_new',
        'is_best',
        'is_sale',
        'is_delete',
        'cat_id',
        'goods_type',
        'img_ori',
        'img_img',
        'img_sam',
        'goods_desc',
        'add_time',
        '_pk' => 'id'
    );

    // 表单白名单
    protected $insertFields = array(
        'goods_name',
        'goods_sn',
        'goods_number',
        'shop_price',
        'market_price',
        'is_hot',
        'is_new',
        'is_best',
        'is_sale',
        'is_delete',
        'cat_id',
        'goods_type',
        'img_ori',
        'img_img',
        'img_sam',
        'goods_desc',
        'add_time'
    );

    // model的自动验证
    protected $_validate = array(
        //array(验证字段1,验证规则,错误提示,[验证条件,附加规则,验证时间]),
        array('goods_name', 'require', '商品名称必须填写！'),
        array('goods_number', 'number', '商品数量不允许为空！'),
        array('shop_price', 'currency', '商品价格必须为货币类型！'),
        array('market_price', 'currency', '市场价格必须为货币类型！'),
        array('cat_id', 'number', '商品所属栏目不合法'),
    );

    // 新增前触发钩子
    protected function _before_insert($data, $options)
    {
        // 载入文件上传
        $upload = new \Think\Upload();
        // 上传文件最大值
        $maxSize = (int)C('UPLOAD_FILE_MAXSIZE');
        $maxfile = (int)ini_get('upload_max_filesize');
        $upload->maxSize = min($maxSize, $maxfile) * 1024 * 1024;

        // 上传文件白名单 在配置文件中定义 大C函数是读取配置文件内容
        $exts = C('UPLOAD_ALLOW_EXT');
        $upload->exts = $exts;

        // 保存根路径
        $rootPath = C('UPLOAD_ROOT_PATH');
        $upload->rootPath = $rootPath;
        // 保存子路径
        $upload->savePath = 'Goods/';

        // 上传
        $info = $upload->upload();

        if (!$info) {
            // 上传错误提示错误信息
            $this->error = $upload->getError();
            return false;
        } else {
            // 拼接源图路径 ./Public/Uploads/Goods/sss.jpg
            $goods_ori = $info['img_ori']['savepath'] . $info['img_ori']['savename'];

            // 实例化缩略图对象
            $image = new \Think\Image();
            // 打开已上传的图片
            $image->open($rootPath . $goods_ori);

            // 缩略图
            $samName1 = $info['img_ori']['savepath'] . 'thumb1' . $info['img_ori']['savename'];
            $samName2 = $info['img_ori']['savepath'] . 'thumb2' . $info['img_ori']['savename'];
            // 生成一个缩放后填充大小150*150的缩略图
            // 生成多张缩略图 要先生成大图 在生成小图
            $image->thumb(230, 230)->save($rootPath . $samName1);
            $image->thumb(100, 100)->save($rootPath . $samName2);

            // 保存数据库
            $data['img_sam'] = $samName2;   // 最小图
            $data['img_img'] = $samName1;   // 中等图
            $data['img_ori'] = $goods_ori;  // 源图
        }
    }

    // 修改前触发钩子
    protected function _before_update(&$data, $options)
    {
        // 载入文件上传
        $upload = new \Think\Upload();
        // 上传文件最大值
        $maxSize = (int)C('UPLOAD_FILE_MAXSIZE');
        $maxfile = (int)ini_get('upload_max_filesize');
        $upload->maxSize = min($maxSize, $maxfile) * 1024 * 1024;

        // 上传文件白名单 在配置文件中定义 大C函数是读取配置文件内容
        $exts = C('UPLOAD_ALLOW_EXT');
        $upload->exts = $exts;

        // 保存根路径
        $rootPath = C('UPLOAD_ROOT_PATH');
        $upload->rootPath = $rootPath;
        // 保存子路径
        $upload->savePath = 'Goods/';

        // 上传
        if($info = $upload->upload()){
            if (!$info) {
                // 上传错误提示错误信息
                $this->error = $upload->getError();
                return false;
            } else {
                // 拼接源图路径 ./Public/Uploads/Goods/sss.jpg
                $goods_ori = $info['img_ori']['savepath'] . $info['img_ori']['savename'];

                // 实例化缩略图对象
                $image = new \Think\Image();
                // 打开已上传的图片
                $image->open($rootPath . $goods_ori);

                // 缩略图
                $samName1 = $info['img_ori']['savepath'] . 'thumb1' . $info['img_ori']['savename'];
                $samName2 = $info['img_ori']['savepath'] . 'thumb2' . $info['img_ori']['savename'];
                // 生成一个缩放后填充大小150*150的缩略图
                // 生成多张缩略图 要先生成大图 在生成小图
                $image->thumb(230, 230)->save($rootPath . $samName1);
                $image->thumb(100, 100)->save($rootPath . $samName2);

                // 保存数据库
                $data['img_sam'] = $samName2;   // 最小图
                $data['img_img'] = $samName1;   // 中等图
                $data['img_ori'] = $goods_ori;  // 源图
            }
        }
    }

    // 将商品属性增加写在钩子中 完成属性数据入库
    protected function _after_insert($data, $options){
        // 获取_before_insert钩子增加完的商品ID
        $goods_id = $data['id'];

        // 接收属性信息
        $attrs = I('post.attr'); // 返回的是二维数组
        // 把属性信息如入库
        foreach ($attrs as $k => $v) {
            if (is_array($v)) {
                // 是数组
                foreach ($v as $v1) {
                    $arr = array(
                        'goods_id' => $goods_id,
                        'arrt_id' => $k,
                        'arrt_value' => $v1
                    );
                    // 入库 GoodsAttr == it_goods_attr
                    M('GoodsAttr')->add($arr);
                }
            }else{
                // 不是数组
                $arr = array(
                    'goods_id' => $goods_id,
                    'arrt_id' => $k,
                    'arrt_value' => $v
                );
                // 入库 GoodsAttr == it_goods_attr
                M('GoodsAttr')->add($arr);
            }
        }
    }

    /**
     * [getByGoods 取出热卖/新品/精品的数据]
     * @param  [type] $type   [类型名称值]
     * @param  [type] $number [取出数据数量]
     * @return [array]        [结果集]
     */
    public function getByGoods($type,$number)
    {
        // 允许类型
        if ($type == 'is_best' || $type == 'is_new' || $type == 'is_hot') {
            // 取出数据
            return  $this->where("{$type} = 1")->order('id desc')->limit($number)->select();
        }
    }
}

?>
