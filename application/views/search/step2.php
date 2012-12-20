<div id="content">
    <div id="infoList_two">
<?php
    if($flag != ''){
        echo $flag;
        
    }  else {
        
        echo "用户:{$userBases[0]['cert_name']}<br/>已通过认证!<br/>";
    }
    
?>

<br/>
<form method="post" action="<?php echo base_url('search/step2')?>">
    <input type="hidden" name="zxcode" value="<?php echo $zxcode;?>"/>
    <label for="sqcode">查询详细信息，请输入授权码：</label><input type="text" id="zxcode" name="sqcode" />
    <input type="submit"  value="查询" />
</form><br/>

<?php
    if($flag == ''){
        echo "<p style='font-size:20;color:red'>客户基本信息：</p>";
        if($userBases[0]['audit'] == 0){
            echo '该客户基本信息未通过审核！';
            exit();
        }
        $ubHtml = "<table  width='500' class='table'>";
        foreach ($userBases as $userBase){
            $ubHtml .= "<tr>";
            $ubHtml .= "<td width='200'>征信编码：{$userBase['zx_code']}</td>";
            $ubHtml .= "<td width='200'>认证法人名称：{$userBase['cert_name']}</td>";
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
    </div>
</div>