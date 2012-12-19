<div>
    <h2><?= $head;?></h2>
</div>
<h4><a href="<?= base_url('admin/addFileType')?>">添加新项目名称</a></h4>
<?php
    $base_url = base_url();
    echo "<form action='{$base_url}admin/searchFileType' method='post'>";
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
    $html .= "<tr><th width='200'>标题名称</th><th width='200'>操作</th></tr>";
    foreach ($fileTypes as $fileType){
        $html .= "<tr>";
        $html .= "<td align='center'>{$fileType['file_name']}</td>";
        //$html .= "<td align='center'><a href='{$base_url}admin/deleteFileType/{$fileType['id']}'><input type='button' value='删除'></a></td>";
        $html .= "<td align='center'><a href='{$base_url}admin/updateFileType/{$fileType['id']}'><input type='button' value='修改'></a></td>";
        $html .= "</tr>";
    }
    echo $html;