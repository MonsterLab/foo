<div>
    <h2><?= $head;?></h2>
</div>
<?php
    if($power == 99){
?>
<p>
    <a href="<?php echo base_url('admin/importCode')?>"><input type="button" value="批量导入征信编码"></a>
</p>
<?php }?>
    <?php
    $base_url = base_url();
    echo "<form action='{$base_url}admin/searchCode' method='post'>";
    echo "征信编码：<input type='text' name='keySearch'>";
    echo "<input type='submit' name='submit' value='搜索'><br><br>";

    if($flag != ''){
        echo $flag;
        exit();
    }
//    echo "<pre>";
//    print_r($zxcodes);
//    echo '</pre>';
    
    $html = "<table>";
    $html .= "<tr><th width='100'>征信编码</th><th width='100'>状态</th><th width='100'>操作</th></tr>";
    foreach ($zxcodes as $zxcode){
        if($zxcode['status'] == 1){
            $state = '已使用';
            $handle = '查看信息';
            $link = base_url("admin/showUserInfos/{$zxcode['zx_code']}/");
        }elseif ($zxcode['status'] == 0) {
            $state = '未使用';
            $handle = '添加客户';
            $link = base_url("admin/createUser/{$zxcode['zx_code']}");
        }
        $html .= "<tr>";
        $html .= "<td align='center'>{$zxcode['zx_code']}</td>";
        $html .= "<td align='center'>{$state}</td>";
        $html .= "<td align='center'><a href='{$link}'><input type='button' value='{$handle}'></a></td>";
        $html .= "</tr>";
    }
    echo $html;
    