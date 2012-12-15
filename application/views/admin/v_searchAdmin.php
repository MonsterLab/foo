<div>
    <h2><?= $head;?></h2>
</div>

<?php

    $base_url = base_url();
    echo "<form action='{$base_url}admin/searchAdmins/' method='post'>";
    echo "管理用户名：<input type='text' name='keySearch'>";
    echo "<input type='submit' name='submit' value='搜索'><br><br>";

    if($flag != ''){
        echo $flag;
        exit();
    }

    
//    echo "<pre>";
//    print_r($admins);
//    echo "</pre>";
    
    $html = "<table>";
    $html .= "<tr><th width='150'>管理用户名</th><th width='150'>使用人</th><th width='150'>部门</th><th width='150'>权限</th><th width='150'>创建时间</th><th width='150'>操作</th></tr>";
    foreach ($admins as $admin){
        $html .= "<tr>";
        $html .= "<td align='center'>{$admin['username']}</td>";
        $html .= "<td align='center'>{$admin['truename']}</td>";
        $html .= "<td align='center'>{$admin['department']}</td>";
        $html .= "<td align='center'>{$admin['power']}</td>";
        $html .= "<td align='center'>{$admin['ctime']}</td>";
        $html .= "<td align='center'><a href='#'>修改</a></td>";
        $html .= "</tr>";
    }
    echo $html;
