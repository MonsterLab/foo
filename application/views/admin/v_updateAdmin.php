<div>
    <h2>添加管理用户</h2>
</div>

<?php
    $base_url = base_url();
    /**
    * 弹出提示信息
    */
   if($flag != ''){
       echo "<script>alert('{$flag}');window.location='{$base_url}admin/updateAdmin/{$adminId}';</script>";
       exit();
   }
   
    echo "<form action='{$base_url}admin/updateAdmin/{$adminId}' method ='post'>";
    echo "*使用人权限：";                    //11客服 12 平台管理 13 录入 14 审核 99超管 
    echo "<select name = 'power'>";
    
    
    
?>

    <option value='14' <?php echo $power==14 ? 'selected' : ''; ?>>审核</option>
    <option value='13' <?php echo $power==13 ? 'selected' : ''; ?>>录入</option>
    <option value='12' <?php echo $power==12 ? 'selected' : ''; ?>>平台管理</option>
    <option value='11' <?php echo $power==11 ? 'selected' : ''; ?>>客服</option>
    
<?php    
    echo "</select><br>";
    echo "*管理用户名："."<input type='text' name='username' value='{$username}'>"."<br>";
    echo "*密码："."<input type='password' name='password' value='{$password}'>"."<br>";
    echo "*使用人："."<input type='text' name='truename' value='{$truename}'>"."<br>";
    echo "*所在部门："."<input type='text' name='department' value='{$department}'>"."<br>";
    echo "电话："."<input type='text' name='phone' value='{$phone}'>"."<br>";
    echo "联系人E-mail："."<input type='text' name='email' value='{$email}'>"."<br>";
    echo "<input type='submit' name='submit' value='提交'>";
    echo "</form>";
?>
