<?php

    $base_url = base_url();
    echo "<form action='{$base_url}admin/searchUsers' method='post'>";
    echo "<input type='text' name='keySearch'>";
    echo "<input type='hidden' name='type' value='{$type}'>";
    echo "<input type='submit' name='submit' value='搜索'><br>";

    if($flag != ''){
        echo $flag;
        exit();
    }

    
//    echo "<pre>";
//    print_r($userBases);
//    echo "</pre>";
    
    $html = "<table>";
    $html .= "<tr><th width='100'>征信编码</th><th width='100'>客户名称</th><th width='100'>创建时间</th><th width='100'>操作</th></tr>";
    foreach ($userBases as $userBase){
        $html .= "<tr>";
        $html .= "<td align='center'>{$userBase['zx_code']}</td>";
        $html .= "<td align='center'>{$userBase['com_name']}</td>";
        $html .= "<td align='center'>{$userBase['ctime']}</td>";
        $html .= "<td align='center'><a href='#'>查看</a>  <a href='#'>删除</a></td>";
        $html .= "</tr>";
    }
    echo $html;
