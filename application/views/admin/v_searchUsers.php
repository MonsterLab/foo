<div>
    <h2><?= $head;?></h2>
</div>

<div>
    <?php 
        //此处根据权限判断是否显示,录入、超管
        if($power == 13 || $power == 99){      
    ?>
        <h4><a href="<?= base_url('admin/searchCode')?>">添加新客户</a></h4>
    <?php }?>
    
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
            $html .= "<td align='center'>{$userBase['cert_name']}</td>";
            $html .= "<td align='center'>{$userBase['ctime']}</td>";
            $html .= "<td align='center'>";
            //$html .= "<a href='{$base_url}admin/createUser/{$userBase['id']}/'><input type='button' value='修改'></a>";
            if($power == 13 || $power == 99){
                $html .= "<a href='{$base_url}admin/showLuruView/{$userBase['id']}/'><input type='button' value='录入'></a>";
            }
            if($power == 14 || $power == 99){
                $html .= "<a href='{$base_url}admin/audit/{$userBase['id']}/{$type}/'><input type='button' value='审核'></a>";
            }
            
            
            $html .= "</td>";
            $html .= "</tr>";
        }
        echo $html;
    ?>
</div>