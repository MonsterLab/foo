<?php
    $base_url = base_url();
    if($flag != ''){
        echo $flag;
        exit();
    }
    
    echo "<form action='{$base_url}index.php/admin/addCertContent' method='post'>";
    echo "认证题目：<input type='text' name='title' value=''><br>";
    echo "认证内容：<textarea name='content' cols='35' rows='8'></textarea><br>";
    echo "<input type='submit' name='submit' value='提交'>";
    echo "</form>";