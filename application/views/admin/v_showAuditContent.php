<div id="content">
    <?php
        echo "标题：{$title}<br>";
        echo "内容：{$content}<br>";
    ?>    
</div> 
<div id="sure">
    <?php
        $base_url = base_url();
        $html = "<a href='{$base_url}admin/audit/{$uid}/{$type}/{$tableType}/{$tid}/1'><input type='button' value='通过'/></a>";
        $html .= "<a href='{$base_url}admin/audit/{$uid}/{$type}/{$tableType}/{$tid}/-1'><input type='button' value='未通过'/></a>";
        echo $html;
    ?>
</div>
