<?php
    /**
     *  过滤xss
     */
    function removeXSS($val){
        static $obj = null;
        if ($obj === null) {
            // 载入核心文件
            require_once ("/Public/HTMLPurifier/HTMLPurifier.includes.php");
            $obj = new HTMLPurifier();
        }

        // 返回过滤后的数据
        return $obj->purify($val);
    }
 ?>
