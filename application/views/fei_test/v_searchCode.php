<?php

//    echo "<pre>";
//    print_r($zxcodes);
//    echo '</pre>';
    
    $html = "<table>";
    $html .= "<tr><th width='100'>征信编码</th><th width='100'>状态</th><th width='100'>操作</th></tr>";
    foreach ($zxcodes as $zxcode){
        $html .= "<tr>";
        $html .= "<td align='center'>{$zxcode['zx_code']}</td>";
        $html .= "<td align='center'>{$zxcode['status']}</td>";
        $html .= "<td align='center'>查看  删除</td>";
        $html .= "</tr>";
    }
    echo $html;
    