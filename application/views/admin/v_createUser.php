<div>
    <h2>添加客户</h2>
</div>

<?php
    $base_url = base_url();
    /**
    * 弹出提示信息
    */
   if($flag != ''){
       echo "<script>alert('{$flag}');window.location='{$base_url}admin/createUser/{$zxcode}';</script>";
       exit();
   }
   
    echo "<form action='{$base_url}admin/createUser/$zxcode' method ='post'>";
    echo "征信编码：{$zxcode}"."<br>";
    echo "所属征信库类型：";                    //11客服 12 平台管理 13 录入 14 审核 99超管 
    echo "<select name = 'type'>";
?>

    <option value='topic' <?php echo $type=='topic' ? 'selected' : ''; ?>>纳税主体</option>
    <option value='medium' <?php echo $type=='medium' ? 'selected' : ''; ?>>中介机构</option>
    <option value='talent' <?php echo $type=='talent' ? 'selected' : ''; ?>>财税人才</option>
    
<?php    
    echo "</select><br>";
    echo "公司名："."<input type='text' name='cert_name' value='{$cert_name}'>"."<br>";
    echo "登录名："."<input type='text' name='username' value='{$username}'>"."<br>";
    echo "密码："."<input type='password' name='password' value='{$password}'>"."<br>";
    echo "授权码："."<input type='text' name='sqcode' value='{$sqcode}'>"."<br>";
    echo "<input type='submit' name='submit' value='提交'>";
    echo "</form>";
?>
