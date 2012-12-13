<?php
    $base_url = base_url();
    if($flag != ''){
        exit($flag);
    }
    //$cuid,$uid,$com_name,$com_nature,$com_phone,$zipcode,$com_place,$industry_id,$cert_begin,$cert_end  
    echo "<form action='{$base_url}admin/createCertBase' method ='post'>";
    
    echo "行业类别：";
    echo "<select name = 'industry'>";
    foreach ($industrys as $industry){
        echo "<option value='{$industry['id']}'>{$industry['industry_name']}</option>";
    }
    echo "</select><br>";
    echo "公司名称："."<input type='text' name='com_name' value=''>"."<br>";
    echo "单位性质："."<input type='text' name='com_nature' value=''>"."<br>";
    echo "公司电话："."<input type='text' name='com_phone' value=''>"."<br>";
    echo "邮政编码："."<input type='text' name='zipcode' value=''>"."<br>";
    echo "公司所在地："."<input type='text' name='com_place' value=''>"."<br>";
    echo "征信开始时间："."<input type='text' name='cert_begin' value=''>"."<br>";
    echo "征信结束时间："."<input type='text' name='cert_end' value=''>"."<br>";
    echo "<input type='submit' name='submit' value='提交'>";
    
    echo "</form>";
