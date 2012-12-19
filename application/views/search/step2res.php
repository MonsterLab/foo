<?php
    
//    echo '<pre>';
//    print_r($certFiles);
//    echo '</pre>';
    
    $base_url = base_url();
    
    if($userBases){
        echo "<h3>客户基本信息：</h3>";
        if($userBases[0]['audit'] == 1){
            $ubHtml = "<table  width='500'>";
            foreach ($userBases as $userBase){
                $ubHtml .= "<tr><td width='200'>征信编码：{$userBase['zx_code']}</td></tr>";
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
            
        }  else {
            echo "客户基本信息未审核！";
        }
    }
    
    if($certBases){
        echo "<h3>认证基本信息：</h3>";
        //判断认证基本信息是否审核
        if($certBases[0]['audit'] == 1){
            $cbHtml = "<table width='500'>";
            foreach ($certBases as $certBase){
                if($userBases[0]['type'] == 'topic' || $userBases[0]['type'] == 'medium'){
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
            echo $cbHtml;
            
        }  else {
            echo "客户认证基本信息未审核！";
        }
    }
    
    if($certFiles){
        echo "<h5>扫描件信息：</h5>";
        $cfHtml = "<table width='500'>";
        foreach ($certFiles as $certFile){
            $cfHtml .= "<tr>";
            $cfHtml .= "<td width='200'>文件名称：{$certFile['file_type_name']}</td>";
            $cfHtml .= "<td width='200'>";
            $cfHtml .= "<img width='450' height='530' style='display:none' src='{$base_url}include/images/{$certFile['file_name']}'/>";
            if($certFile['audit'] == 1){
                $cfHtml .= "<input type='button' class='showPic_button' value='查看'>";
            }  else {
                $cfHtml .= "未审核";
            }
            $cfHtml .= "</td>";
            $cfHtml .= "</tr>";
        }
        $cfHtml .= '</table><br>';

        echo $cfHtml; 
    }
      
    
    if($certContents){
            echo "<h5>文字类信息：</h5>";
            $cfHtml = "<table width='500'>";
            foreach ($certContents as $certContent){
                $cfHtml .= "<tr>";
                $cfHtml .= "<td width='200'>标题：{$certContent['title']}</td>";
                $cfHtml .= "<td width='200'>";
                if($certContent['audit'] == 1){
                    $cfHtml .= "<input type='button' class='showPic_button' value='查看'>";
                }  else {
                    $cfHtml .= "未审核";
                }
                $cfHtml .= "</td>";
                $cfHtml .= "</tr>";
            }
            $cfHtml .= '</table><br>';

            echo $cfHtml; 
        
    }
    