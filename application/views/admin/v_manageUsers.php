<div>
    <h2>客户管理</h2>
</div>

<div>
        <h4><a href="<?= base_url('admin/searchCode')?>">添加新客户</a></h4>
    
    <?php 

        $base_url = base_url();
        echo "<form action='{$base_url}admin/searchUsers/' method='post'>";
        echo "<input type='text' name='keySearch'>";
        echo "<input type='submit' name='submit' value='搜索'><br>";

        if($flag != ''){
            echo $flag;
            exit();
        }

        $html = "<table>";
        $html .= "<tr><th width='200'>征信编码</th><th width='200'>客户名称</th><th width='200'>客户类型</th><th width='200'>创建时间</th><th width='200'>操作</th></tr>";
        foreach ($userBases as $userBase){
            if($userBase['type'] == 'topic'){
                $fooType = '纳税主体';
            }elseif ($userBase['type'] == 'medium') {
                $fooType = '中介机构';
            }elseif ($userBase['type'] == 'medium') {
                $fooType = '财税人才';
            }
            $html .= "<tr>";
            $html .= "<td align='center'>{$userBase['zx_code']}</td>";
            $html .= "<td align='center'>{$userBase['cert_name']}</td>";
            $html .= "<td align='center'>{$fooType}</td>";
            $html .= "<td align='center'>{$userBase['ctime']}</td>";
            $html .= "<td align='center'><a href='{$base_url}admin/createUser/{$userBase['zx_code']}/{$userBase['id']}/'><input type='button' value='修改'></a>";
            
            $html .= "<a href='{$base_url}admin/createUserBase/{$userBase['type']}/{$userBase['zx_code']}'><input type='button' value='录入'></a>";  
            if($power == 14 || $power == 99){
                $html .= "<a href='{$base_url}admin/audit/{$userBase['id']}/{$type}/'><input type='button' value='审核'></a>";
            }
            
            $html .= "</td>";
            $html .= "</tr>";
        }
        echo $html;
    ?>
</div>