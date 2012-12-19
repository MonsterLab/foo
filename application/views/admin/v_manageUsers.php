<div>
    <h2>客户管理</h2>
</div>

<div>
        <h4><a href="<?= base_url('admin/createUser')?>">添加新客户</a></h4>
    
    <?php 
        $base_url = base_url();
        echo "<form action='{$base_url}admin/searchUsers/' method='post'>";
        echo "<label for='key'>征信编码：</label>";
        echo "<input type='text' id='key' name='keySearch'>";
        echo "<input type='submit' name='submit' value='搜索'><br>";

        if($flag != ''){
            echo $flag;
            exit();
        }

        $html = "<table>";
        $html .= "<tr><th width='150'>征信编码</th><th width='150'>联系人姓名</th><th width='150'>客户类型</th><th width='200'>创建时间</th><th width='200'>操作</th></tr>";
        foreach ($userBases as $userBase){
            if($userBase['type'] == 'topic'){
                $fooType = '纳税主体';
            }elseif ($userBase['type'] == 'medium') {
                $fooType = '中介机构';
            }elseif ($userBase['type'] == 'talent') {
                $fooType = '财税人才';
            }
            $html .= "<tr>";
            $html .= "<td align='center'>{$userBase['zx_code']}</td>";
            $html .= "<td align='center'>{$userBase['truename']}</td>";
            $html .= "<td align='center'>{$fooType}</td>";
            $html .= "<td align='center'>{$userBase['ctime']}</td>";
            
            $html .= "<td align='center'>";
            if($userBase['space_id'] == 0){
                $html .= "<a href='{$base_url}admin/setUserSpace/{$userBase['id']}/1'><input type='button' value='开通空间'></a>";
            }  else {
                $html .= "<a href='{$base_url}admin/setUserSpace/{$userBase['id']}/0'><input type='button' value='关闭空间'></a>";
            }
            $html .= "<a href='{$base_url}admin/showLuruView/{$userBase['id']}'><input type='button' value='录入'></a>";  
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