<div>
    <h2>添加用户基本信息</h2>
</div>

<?php
    $base_url = base_url();
    if($flag != ''){
        exit($flag);
    }
?>        
<form action="<?php echo base_url("admin/createUserBase/{$uid}/{$zxcode}") ?>" method ='post'>
    征信编码：<?= $zxcode?><br>
    联系人：<input type='text' name='truename' value='<?php echo $userBases[0]['truename']?>'><br>
    联系人职位：<input type='text' name='position' value='<?php echo $userBases[0]['position']?>'><br>
    联系人电话：<input type='text' name='phone' value='<?php echo $userBases[0]['phone']?>'><br>
    联系人E-mail：<input type='text' name='email' value='<?php echo $userBases[0]['email']?>'><br>
    
    <?php if($noneShow1){?>
    <input type='submit' name='submit' value='提交'>
    <?php 
        }  else {
    ?>        
     <span style="color: red ; font-weight:  bolder">已提交</span>      
     <?php }?>   
    
</form>
