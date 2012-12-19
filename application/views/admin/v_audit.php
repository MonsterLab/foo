<?php
    
    $base_url = base_url();
    
    if($userBases){
        echo "<h3>客户基本信息：</h3>";
        $ubHtml = "<table  width='500'>";
        foreach ($userBases as $userBase){
            $ubHtml .= "<tr><td>征信编码：{$userBase['zx_code']}</td></tr>";
            $ubHtml .= "<tr>";
            $ubHtml .= "<td width='100'>联系人姓名：{$userBase['truename']}</td>";
            $ubHtml .= "<td >联系人电话：{$userBase['phone']}</td>";
            $ubHtml .= "</tr>";
            $ubHtml .= "<tr>";
            $ubHtml .= "<td width='100'>联系人职位：{$userBase['position']}</td>";
            $ubHtml .= "<td >电子邮件：{$userBase['email']}</td>";
            $ubHtml .= "</tr>";
        }
        $ubHtml .= '</table><br>';

        $tablename = 'userbase';
        if($userBase['audit'] == 0){
            $ubHtml .= "<a href='{$base_url}admin/audit/{$uid}/{$type}/{$tablename}/{$userBase['id']}/1'><input type='button' name='userbase_bt' value='通过'/></a>";
            $ubHtml .= "<a href='{$base_url}admin/audit/{$uid}/{$type}/{$tablename}/{$userBase['id']}/-1'><input type='button' name='userbase_bt' value='未通过'/></a>";
        }  else {
            $ubHtml .= "已审核";
        }
        

        echo $ubHtml;
    }
    
    if($certBases){
        echo "<h3>认证基本信息：</h3>";
        $cbHtml = "<table width='500'>";
        foreach ($certBases as $certBase){
            if($type == 'topic' || $type == 'medium'){
                $cbHtml .= "<tr>";
                $cbHtml .= "<td width='200'>认证法人名称：{$certBase['com_name']}</td>";
                $cbHtml .= "<td width='200'>单位性质：{$certBase['com_nature']}</td>";
                $cbHtml .= "</tr>";
                $cbHtml .= "<tr>";
                $cbHtml .= "<td width='200'>行业类别：{$certBase['industry_id']}</td>";
                $cbHtml .= "<td width='200'>单位电话：{$certBase['com_phone']}</td>";
                $cbHtml .= "</tr>";
                $cbHtml .= "<tr>";
                $cbHtml .= "<td width='200'>邮政编码：{$certBase['zipcode']}</td>";
                $cbHtml .= "<td width='200'>所在地址：{$certBase['com_place']}</td>";
                $cbHtml .= "</tr>";
                $cbHtml .= "<tr>";
                $cbHtml .= "<td width='400'>征信期限：{$certBase['cert_begin']}-{$certBase['cert_end']}</td>";
                $cbHtml .= "</tr>";

            }  else {
                if($certBase['sex']){
                    $sex = '男';
                }  else {
                    $sex = '女';
                }
                $cbHtml .= "<tr>";
                $cbHtml .= "<td width='200'>认证法人名称：{$certBase['cert_name']}</td>";
                $cbHtml .= "<td width='200'>性别：{$sex}</td>";
                $cbHtml .= "</tr>";
                $cbHtml .= "<tr>";
                $cbHtml .= "<td width='200'>民族：{$certBase['nation']}</td>";
                $cbHtml .= "<td width='200'>身份证号：{$certBase['personid']}</td>";
                $cbHtml .= "</tr>";
                $cbHtml .= "<tr>";
                $cbHtml .= "<td width='200'>出生地：{$certBase['birth_place']}</td>";
                $cbHtml .= "<td width='200'>现居地：{$certBase['live_place']}</td>";
                $cbHtml .= "</tr>";
                $cbHtml .= "<tr>";
                $cbHtml .= "<td width='400'>征信期限：{$certBase['cert_begin']}-{$certBase['cert_end']}</td>";
                $cbHtml .= "</tr>";
            }
        }
        $cbHtml .= '</table><br>';
        
        $tablename = 'certbase';
        if($certBase['audit'] == 0){
            $cbHtml .= "<a href='{$base_url}admin/audit/{$uid}/{$type}/{$tablename}/{$userBase['id']}/1'><input type='button' name='userbase_bt' value='通过'/></a>";
            $cbHtml .= "<a href='{$base_url}admin/audit/{$uid}/{$type}/{$tablename}/{$userBase['id']}/-1'><input type='button' name='userbase_bt' value='未通过'/></a>";
        }  else {
            $cbHtml .= "已审核";
        }
    
        echo $cbHtml;
    }
    
    
    
    if($certFiles){
        $tableType = 'certfile';
        echo "<h3>扫描文件信息：</h3>";
        $cfHtml = "<table width='500'>";
        foreach ($certFiles as $certFile){
            $cfHtml .= "<tr>";
            $cfHtml .= "<td width='200'>文件名称：{$certFile['file_type_name']}</td>";
            $cfHtml .= "<td width='200'>";
            if($certFile['audit'] == 0){
                $cfHtml .= form_open("{$base_url}admin/showFileOrContent/{$uid}/{$type}/{$tableType}/{$certFile['id']}");
                $cfHtml .= "<input type='hidden' name='fileName' value='{$certFile['file_name']}'>";
                $cfHtml .= "<input type='submit' name='submit' value='审核'/>";
                $cfHtml .= form_close();
            }  else {
                $cfHtml .= "已审核";
            }
            $cfHtml .= "</td>";
            $cfHtml .= "</tr>";
        }
        $cfHtml .= '</table><br>';
        
        echo $cfHtml;  
    }
      
    
    if($certContents){
        $tableType = 'certcontent';
        echo "<h3>文字类信息：</h3>";
        $ccHtml = "<table width='500'>";
        foreach ($certContents as $certContent){
            $ccHtml .= "<tr>";
            $ccHtml .= "<td width='200'>文件名称：{$certContent['title']}</td>";
            
            $ccHtml .= "<td width='200'>";
            if($certContent['audit'] == 0){
                $ccHtml .= form_open("{$base_url}admin/showFileOrContent/{$uid}/{$type}/{$tableType}/{$certContent['id']}");
                $ccHtml .= "<input type='hidden' name='title' value='{$certContent['title']}'>";
                $ccHtml .= "<input type='hidden' name='content' value='{$certContent['content']}'>";
                $ccHtml .= "<input type='submit' name='submit' value='审核'/>";
                $ccHtml .= form_close();
            }  else {
                $ccHtml .= "已审核";
            }
            $ccHtml .= "</td>";
            
            $ccHtml .= "</tr>";
        }
        $ccHtml .= '</table><br>';
        
        echo $ccHtml; 
    }
    