<div>
    <h2><?= $head;?></h2>
</div>

<div>
    <h4><a href="<?= base_url('admin/createAdmin')?>">添加新管理用户</a></h4><br/>

    <?php

        $base_url = base_url();
        echo "<form action='{$base_url}admin/searchAdmins/' method='post'>";
        echo "管理用户名：<input type='text' name='keySearch'>";
        echo "<input type='submit' name='submit' value='搜索'><br><br>";

        if($flag != ''){
            echo $flag;
            exit();
        }


        $html = "<table>";
        $html .= "<tr><th width='150'>管理用户名</th><th width='150'>使用人</th><th width='150'>部门</th><th width='150'>权限</th><th width='150'>创建时间</th><th width='150'>操作</th></tr>";
        foreach ($admins as $admin){
            if($admin['power'] == 11){
                $state = '客服';
            }
            if($admin['power'] == 12){
                $state = '平台管理';
            }
            if($admin['power'] == 13){
                $state = '录入';
            }
            if($admin['power'] == 14){
                $state = '审核';
            }
            if($admin['power'] == 99){
                $state = '超级管理员';
            }
            
            $html .= "<tr>";
            $html .= "<td align='center'>{$admin['username']}</td>";
            $html .= "<td align='center'>{$admin['truename']}</td>";
            $html .= "<td align='center'>{$admin['department']}</td>";
            $html .= "<td align='center'>{$state}</td>";
            $html .= "<td align='center'>{$admin['ctime']}</td>";
            $html .= "<td align='center'><a href='{$base_url}admin/updateAdmin/{$admin['id']}/'><input type='button' value='修改'></a>   ";
            $html .= "<a href='{$base_url}admin/deleteAdmin/{$admin['id']}/'><input type='button' value='删除'></a></td>";
            $html .= "</tr>";
        }
        echo $html;
    ?>
</div>