<?php
//create($cuid,$zx_code,$sq_code,$username,$password,$truename,$position,$phone,$email,$type)
    
    echo "<form action=''>";
    echo "征信编码："."<input type='text' name='zxcode' value=''>"."<br>";
    echo "授权密码："."<input type='text' name='sqcode' value=''>"."<br>";
    echo "登录名："."<input type='text' name='username' value=''>"."<br>";
    echo "登录密码："."<input type='text' name='password' value=''>"."<br>";
    echo "征联系人："."<input type='text' name='truename' value=''>"."<br>";
    echo "联系人职位："."<input type='text' name='position' value=''>"."<br>";
    echo "联系人电话："."<input type='text' name='phone' value=''>"."<br>";
    echo "联系人E-mail："."<input type='text' name='email' value=''>"."<br>";
    echo "类型："."<select name='type'><option>纳税主体</option><option>中介机构</option><option>财税人才</option></select>"."<br>";
    echo "<input type='submit' name='submit' value='提交'>";
    echo "</form>";
