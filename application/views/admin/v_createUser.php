<div>
    <h2>添加客户基本信息</h2>
</div>

<?php
    $base_url = base_url();
    /**
    * 弹出提示信息
    */
   if($flag != ''){
       echo "<script>alert('{$flag}');window.location='{$base_url}admin/createUser/';</script>";
       exit();
   }
?>  
<div>
    <form action='<?php base_url('admin/createUser/')?>' method ='post'>
    <label for="zxcode">征信编码：</label>
    <?php if($zxcode == ''){?>
        <input type="text" id="zxcode" name="zxcode"><br/>
    <?php }else{?>
        <input type="text" id="zxcode" name="zxcode" value="<?= $zxcode?>" disabled><br/>
    <?php }?>    
    <label for="sqcode">授权码：</label><input type='text' id="sqcode" name='sqcode' value=''><br/>
    <label for="type">所属征信库类型：</label>
        <select name = 'type'>
        <option value='topic' >纳税主体</option>
        <option value='medium' >中介机构</option>
        <option value='talent' >财税人才</option>
        </select><br>
    <label for="username">登录名：</label><input type='text' id="username" name='username' value=''><br>
    <label for="password">密码：</label><input type='password' id="password" name='password' value=''><br>
    <label for="truename">联系人：</label><input type='text' id="truename" name='truename' value=''><br>
    <label for="position">职位：</label><input type='text' id="position" name='position' value=''><br>
    <label for="phone">电话：</label><input type='text' id="phone" name='phone' value=''><br>
    <label for="email">邮箱：</label><input type='text' id="email" name='email' value=''><br>
    
    <input type='submit' name='submit' value='提交'>
    </form>
</div>
