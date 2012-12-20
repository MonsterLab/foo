<head>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
</head>
<?php
    $base_url = base_url();
    if($flag != ''){
        echo $flag;
        exit();
    }
?>  

<div>
    <h2><?= $head?>用户基本信息</h2>
</div>

<?php
    //添加、修改共用
    if($handle == 'add'){
        echo "<form action='{$base_url}admin/createUserBase/{$uid}/{$zxcode}' method ='post'>";
    }  elseif($handle == 'update') {
        echo "<form action='{$base_url}admin/updateUserBase/{$uid}/' method ='post'>";
    }
?>        

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
