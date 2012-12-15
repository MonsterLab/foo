<div>
    <h2>添加用户基本信息</h2>
</div>

<?php
//create($cuid,$zx_code,$sq_code,$username,$password,$truename,$position,$phone,$email,$type)
    $base_url = base_url();
    if($flag != ''){
        exit($flag);
    }
        
    echo "<form action='{$base_url}admin/createUserBase/{$type}/{$zxcode}' method ='post'>";
    echo "征信编码：$zxcode<br>";
    echo "授权密码："."<input type='text' name='sqcode' value=''>"."<br>";
    echo "登录名："."<input type='text' name='username' value=''>"."<br>";
    echo "登录密码："."<input type='password' name='password' value=''>"."<br>";
    echo "征联系人："."<input type='text' name='truename' value=''>"."<br>";
    echo "联系人职位："."<input type='text' name='position' value=''>"."<br>";
    echo "联系人电话："."<input type='text' name='phone' value=''>"."<br>";
    echo "联系人E-mail："."<input type='text' name='email' value=''>"."<br>";
    echo "<input type='submit' name='submit' value='提交'>";
    echo "</form>";
