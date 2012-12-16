<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <script type="text/javascript" src="<?= base_url()?>js/jquery-1.7.2.min.js"></script>
        
        <link type="text/css" href="<?= base_url()?>include/css/datepicker/jquery-ui-1.8.16.custom.css" rel="stylesheet" />	
        <link type="text/css" href="<?= base_url()?>include/css/datepicker/jquery.ui.slider.css" rel="stylesheet" />	
        <script type="text/javascript" src="<?= base_url()?>include/js/datepicker/jquery-1.6.2.min.js"></script>
        <script type="text/javascript" src="<?= base_url()?>include/js/datepicker/jquery-ui-1.8.16.custom.min.js"></script>
        <script type="text/javascript" src="<?= base_url()?>include/js/datepicker/fz.js"></script>
        <script type="text/javascript" src="<?= base_url()?>include/js/datepicker/jquery-ui-timepicker-addon.js"></script>	
        <script type="text/javascript" src="<?= base_url()?>include/js/datepicker/jquery.ui.slider.min.js"></script>
        
        <script type="text/javascript">
                $(function(){
                        showTimePanel("cert_begin");
                        showTimePanel("cert_end");
                });
	</script>
</head>
<body>



<div>
    <h2>添加认证基本信息</h2>
</div>

<?php
    $base_url = base_url();
    if($flag != ''){
        exit($flag);
    }
    //$cuid,$uid,$com_name,$com_nature,$com_phone,$zipcode,$com_place,$industry_id,$cert_begin,$cert_end  
    echo "<form action='{$base_url}admin/createCertBase/{$type}/{$uid}' method ='post'>";
    
    echo "行业类别：";
    echo "<select name = 'industry'>";
    foreach ($industrys as $industry){
        echo "<option value='{$industry['id']}'>{$industry['industry_name']}</option>";
    }
    echo "</select><br>";
    echo "公司名称："."<input type='text' name='com_name' value='{$certBases[0]['com_name']}'>"."<br>";
    echo "单位性质："."<input type='text' name='com_nature' value='{$certBases[0]['com_nature']}'>"."<br>";
    echo "公司电话："."<input type='text' name='com_phone' value='{$certBases[0]['com_phone']}'>"."<br>";
    echo "邮政编码："."<input type='text' name='zipcode' value='{$certBases[0]['zipcode']}'>"."<br>";
    echo "公司所在地："."<input type='text' name='com_place' value='{$certBases[0]['com_place']}'>"."<br>";
    echo "征信开始时间："."<input type='text' id='cert_begin' name='cert_begin' value='{$certBases[0]['cert_begin']}'>"."<br>";
    echo "征信结束时间："."<input type='text' id='cert_end' name='cert_end' value='{$certBases[0]['cert_end']}'>"."<br>";
    if($noneShow2){
        echo "<input type='submit' name='submit' value='提交'>";
    }
    
    
    echo "</form>";
?>
    
</body>
</html>    
    