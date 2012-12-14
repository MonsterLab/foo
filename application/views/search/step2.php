<?php
    if($flag != ''){
        echo $flag;
        
    }  else {
        
        echo "用户:{$userBases[0]['com_name']}<br/>已通过认证!<br/>";
    }
    
?>

输入授权编码:<br/>
<form method="post" action="<?php echo base_url('search/step2')?>">
    <input type="hidden" name="zxcode" value="<?php echo $zxcode;?>"/>
    <input type="text" name="sqcode" />
    <input type="submit" value="查询" />
</form><br/>

<?php
    if($flag == ''){
        echo "<h3>客户基本信息：</h3>";
        $ubHtml = "<table  width='500'>";
        foreach ($userBases as $userBase){
            $ubHtml .= "<tr>";
            $ubHtml .= "<td width='200'>征信编码：{$userBase['zx_code']}</td>";
            $ubHtml .= "<td width='200'>公司名称：{$userBase['com_name']}</td>";
            $ubHtml .= "</tr>";
            $ubHtml .= "<tr>";
            $ubHtml .= "<td width='200'>联系人姓名：{$userBase['truename']}</td>";
            $ubHtml .= "<td width='200'>联系人电话：{$userBase['phone']}</td>";
            $ubHtml .= "</tr>";
            $ubHtml .= "<tr>";
            $ubHtml .= "<td width='200'>联系人职位：{$userBase['position']}</td>";
            $ubHtml .= "<td width='200'>电子邮件：{$userBase['email']}</td>";
            $ubHtml .= "</tr>";
        }
        $ubHtml .= '</table><br>';

        echo $ubHtml;
    }
?>