<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        
        <script type="text/javascript" src="<?php echo base_url('include/js/jquery-1.3.1.min.js')?>"></script>
        
        <link type="text/css" href="<?php echo base_url('include/css/datepicker/jquery-ui-1.8.16.custom.css')?>" rel="stylesheet" />	
        <link type="text/css" href="<?php echo base_url('include/css/datepicker/jquery.ui.slider.css')?>" rel="stylesheet" />	
        <script type="text/javascript" src="<?php echo base_url('include/js/datepicker/jquery-1.6.2.min.js')?>"></script>
        <script type="text/javascript" src="<?php echo base_url('include/js/datepicker/jquery-ui-1.8.16.custom.min.js')?>"></script>
        <script type="text/javascript" src="<?php echo base_url('include/js/datepicker/fz.js')?>"></script>
        <script type="text/javascript" src="<?php echo base_url('include/js/datepicker/jquery-ui-timepicker-addon.js')?>"></script>	
        <script type="text/javascript" src="<?php echo base_url('include/js/datepicker/jquery.ui.slider.min.js')?>"></script>
        
        <script type="text/javascript">
                $(function(){
                        showTimePanel("cert_begin");
                        showTimePanel("cert_end");
                });
	</script>
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
    <h2><?= $head?>认证基础信息</h2>
</div>

<?php
    
    if($handle == 'add'){
        echo "<form action='{$base_url}admin/createCertBase/{$type}/{$uid}/{$certBases[0]['id']}' method ='post'>";
    }  else {
        echo "<form action='{$base_url}admin/updateCertBase/{$type}/{$uid}/{$certBases[0]['id']}' method ='post'>";
    }
?> 
<?php 
    if($type == 'topic' || $type == 'medium'){
?>    
        行业类别：
        <select name = 'industry'>
     <?php
        foreach ($industrys as $industry){
            if($industry['id'] == $certBases[0]['industry_id']){
                echo "<option value='{$industry['id']}' selected>{$industry['industry_name']}</option>";
            }  else {
                echo "<option value='{$industry['id']}' >{$industry['industry_name']}</option>";
            }
        }
     ?>
        </select><br>
        公司名称：<input type='text' name='com_name' value='<?php echo $certBases[0]['com_name']?>'><br>
        单位性质：<input type='text' name='com_nature' value='<?php echo $certBases[0]['com_nature']?>'><br>
        公司电话：<input type='text' name='com_phone' value='<?php echo $certBases[0]['com_phone']?>'><br>
        邮政编码：<input type='text' name='zipcode' value='<?php echo $certBases[0]['zipcode']?>'><br>
        公司所在地：<input type='text' name='com_place' value='<?php echo $certBases[0]['com_place']?>'><br>
        征信开始时间：<input type='text' id='cert_begin' name='cert_begin' value='<?php echo $certBases[0]['cert_begin']?>'><br>
        征信结束时间：<input type='text' id='cert_end' name='cert_end' value='<?php echo $certBases[0]['cert_end']?>'><br>
        
<?php
}  else {
 ?> 
        客户名：<input type='text' name='cert_name' value='<?php echo $certBases[0]['cert_name']?>'><br>
        性别：<input type='radio' name='sex' value="1" <?php if($certBases[0]['sex']){echo 'checked';}?>/>男<input type='radio' name='sex' value ="0" <?php if(!$certBases[0]['sex']){echo 'checked';}?>>女<br><br>
        民族：<input type='text' name='nation' value='<?php echo $certBases[0]['nation']?>'><br>
        身份证：<input type='text' name='personid' value='<?php echo $certBases[0]['personid']?>'><br>
        出生地：<input type='text' name='birth_place' value='<?php echo $certBases[0]['birth_place']?>'><br>
        现居地：<input type='text' name='live_place' value='<?php echo $certBases[0]['live_place']?>'><br>
        征信开始时间：<input type='text' id='cert_begin' name='cert_begin' value='<?php echo $certBases[0]['cert_begin']?>'><br>
        征信结束时间：<input type='text' id='cert_end' name='cert_end' value='<?php echo $certBases[0]['cert_end']?>'><br>
   
    
    
<?php }?>  
    
<?php if($noneShow2){?>
    <input type='submit' name='submit' value='提交'>
<?php 
    }  else {
?>        
    <span style="color: red ; font-weight:  bolder">已提交</span>      
<?php }?> 
    
    
    </form>

    
</body>
 </html>   