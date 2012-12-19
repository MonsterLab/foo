<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>中国经济网 信用频道</title>
<script src="<?php echo base_url('include/js/jquery-1.3.1.min.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('include/js/showPic.js')?>" type="text/javascript"></script>
</head>
<body>
<?php
    $base_url = base_url();
    if($flag != ''){
        echo $flag;
        exit();
    }
?>  
    
<div>
    <h2><?= $head?>认证扫描件信息</h2>
</div>
  
<div>
    
    <?php
        if($certFiles){
            echo "<h5>已上传文件：</h5>";
            $cfHtml = "<table width='500'>";
            foreach ($certFiles as $certFile){
                $cfHtml .= "<tr>";
                $cfHtml .= "<td width='200'>文件名称：{$certFile['file_type_name']}</td>";
                $cfHtml .= "<td width='200'>";
                $cfHtml .= "<img width='450' height='530' style='display:none' src='{$base_url}include/images/{$certFile['file_name']}'/>";
                $cfHtml .= "<input type='button' class='showPic_button' value='查看'>";
                if($handle == 'update'){
                    $cfHtml .= "<a href='{$base_url}admin/updateCertFile/{$certFile['id']}/{$certFile['file_type_id']}/$type/{$certFile['uid']}/'><input type='button' value='修改'>";
                }
                $cfHtml .= "</td>";
                $cfHtml .= "</tr>";
            }
            $cfHtml .= '</table><br>';

            echo $cfHtml; 
        }
    ?>
</div>    
<?php if($handle == 'add'){?>
<div>    
    <form action='<?php echo base_url("admin/addCertFile/{$type}/{$uid}")?>' method='post' enctype='multipart/form-data'>

        证书名：
        <select name='filename'>
    <?php        
        foreach ($fileTypes as $fileType){
            echo "<option value='{$fileType['id']}'>{$fileType['file_name']}</option>";
        }
    ?>    
        </select><br>
        上传文件：<input type='file' name='file' value='' /><br>
        <input type='submit' name='submit' value='上传'>
    </form>
</div>    
<?php }?>
</body>
</html>