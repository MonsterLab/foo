<div>
    <h2>行业分类设置</h2>
</div>
<h4><a href="<?= base_url('admin/addIndustry')?>">添加新行业名称</a></h4>
<?php
    $base_url = base_url();
    echo "<form action='{$base_url}admin/searchIndustry' method='post'>";
    echo "<select name='type'>";
    echo "<option value='topic'>纳税主体征信库</option>";
    echo "<option value='medium'>中介机构征信库</option>";
    echo "<option value='talent'>财税人才征信库</option>";
    echo "</select>";
    echo "<input type='submit' name='submit' value='搜索'><br><br>";

    if($flag != ''){
        echo $flag;
        exit();
    }
    
    $html = "<table>";
    $html .= "<tr><th width='200'>行业名称</th><th width='200'>操作</th></tr>";
    foreach ($industrys as $industry){
        $html .= "<tr>";
        $html .= "<td align='center'>{$industry['industry_name']}</td>";
        //$html .= "<td align='center'><a href='{$base_url}admin/deleteIndustry/{$industry['id']}'><input type='button' value='删除'></a>";
        $html .= "<td align='center'><a href='{$base_url}admin/updateIndustry/{$industry['id']}'><input type='button' value='修改'></a></td>";
        $html .= "</tr>";
    }
    echo $html;