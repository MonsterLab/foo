<div>
    <h2><?= $head;?></h2>
</div>

<?php

    $base_url = base_url();
    echo "<form action='{$base_url}admin/searchUsers/{$type}' method='post'>";
    echo "<input type='text' name='keySearch'>";
    echo "<input type='submit' name='submit' value='搜索'><br>";

    if($flag != ''){
        echo $flag;
        exit();
    }

    
//    echo "<pre>";
//    print_r($userBases);
//    echo "</pre>";
    
    $html = "<table>";
    $html .= "<tr><th width='200'>征信编码</th><th width='200'>客户名称</th><th width='200'>创建时间</th><th width='200'>操作</th></tr>";
    foreach ($userBases as $userBase){
        $html .= "<tr>";
        $html .= "<td align='center'>{$userBase['zx_code']}</td>";
        $html .= "<td align='center'>{$userBase['com_name']}</td>";
        $html .= "<td align='center'>{$userBase['ctime']}</td>";
        $html .= "<td align='center'><a href='{$base_url}admin/createUserBase/{$userBase['type']}/{$userBase['zx_code']}'>录入</a>  <a href='{$base_url}admin/audit/{$userBase['id']}/{$type}/'>审核</a></td>";
        $html .= "</tr>";
    }
    echo $html;
