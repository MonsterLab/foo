<head>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
</head>
<div>
    <h2><?= $head;?></h2>
</div>

<div>
    <?php 
        //此处根据权限判断是否显示,录入、超管
        if($power == 13 || $power == 99){      
    ?>
        <h4><a href="<?= base_url('admin/createUser/')?>">添加新客户</a></h4>
    <?php }?>
    
    <?php 

        $base_url = base_url();
        echo "<form action='{$base_url}admin/searchUsers/{$type}' method='post'>";
        echo "<label for='key'>征信编码：</label>";
        echo "<input type='text' id='key' name='keySearch'>";
        echo "<input type='submit' name='submit' value='搜索'><br>";

        if($flag != ''){
            echo $flag;
            exit();
        }


        $html = "<table>";
        $html .= "<tr><th width='200'>征信编码</th><th width='200'>联系人名称</th><th width='200'>创建时间</th><th width='200'>操作</th></tr>";
        foreach ($userBases as $userBase){
            $html .= "<tr>";
            $html .= "<td align='center'>{$userBase['zx_code']}</td>";
            $html .= "<td align='center'>{$userBase['truename']}</td>";
            $html .= "<td align='center'>{$userBase['ctime']}</td>";
            
            $html .= "<td align='center'>";
            
            if($power == 13 || $power == 99){
                if($userBase['space_id'] == 0 ){
                    $html .= "<a href='{$base_url}admin/setUserSpace/{$userBase['id']}/1/{$userBase['type']}'><input type='button' value='开通空间'></a>";
                }  else {
                    $html .= "<a href='{$base_url}admin/setUserSpace/{$userBase['id']}/0/{$userBase['type']}'><input type='button' value='关闭空间'></a>";
                }
                $html .= "<a href='{$base_url}admin/showLuruView/{$userBase['id']}'><input type='button' value='录入'></a>";  
            }
            if($power == 14 || $power == 99){
                $html .= "<a href='{$base_url}admin/audit/{$userBase['id']}/{$userBase['type']}/'><input type='button' value='审核'></a>";
            }
            if($power == 99){
                $html .= "<a href='{$base_url}admin/showUpdateView/{$userBase['id']}/'><input type='button' value='修改'></a>";
                $html .= "<a href='{$base_url}admin/deleteUser/{$userBase['id']}/{$userBase['type']}/'><input type='button' value='删除'></a>"; 
            }
            $html .= "</td>";
            
            $html .= "</tr>";
        }
        echo $html;
    ?>
</div>