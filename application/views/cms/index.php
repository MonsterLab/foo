<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>中国经济网 信用频道</title>
<link href="<?php echo base_url('include/css/client/index.css');?>" type="text/css" rel="stylesheet" />
</head>
<body>
    <?php
        /**
         * 弹出提示信息
         */
        if(isset($flag) && $flag != ''){
            $base_url = base_url();
            echo "<script>alert('{$flag}');window.location='{$base_url}cms/index/';</script>";
            exit();
        }
        
    ?>
<div id="main">
	<div id="top">
    	<div class="form">
            <form action="<?php echo base_url('search/step1');?>" method="post">
                <p class="minP">
                    <label>纳税主体: </label>
                    <input type="text" name="zxcode" size="20" />
                    <input type="submit" value='' class="button" />
                </p>
            </form>
            <form action="<?php echo base_url('search/step1');?>" method="post">
                <p class="minP">
                    <label>财税中介: </label>
                    <input type="text" name="zxcode" size="20" />
                    <input type="submit" value='' class="button" />
                </p>
            </form>
            <form action="<?php echo base_url('search/step1');?>" method="post">
                <p class="minP">
                    <label>财税人才: </label>
                    <input type="text" name="zxcode" size="20" />
                    <input type="submit" value='' class="button" />
                </p>
            </form>
        </div>
    </div>
    <div id="bottom">
        <?php echo $guide; ?>
<!--    	<ul>
            <li class="first"><a href="">中心简介</a></li>
            <li><a href="">征信范围</a></li>
            <li><a href="">办理流程</a></li>
            <li><a href="">后续服务</a></li>
            <li><a href="">合作单位</a></li>
            <li><a href="">征信单位</a></li>
            <li><a href="">征信个人</a></li>
            <li><a href="">用户登录</a></li>
            <li class="returnI"><a href="<?php echo base_url();?>">返回平台首页</a></li>
        </ul>-->
    </div>
</div>
    
    
</body>
</html>