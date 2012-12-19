<div>
    <h3>查看客户信息</h3>
</div>

<?php
    
//    echo '<pre>';
//    print_r($certFiles);
//    echo '</pre>';
    
    $base_url = base_url();
    if($flag != ''){
        echo $flag;
        exit();
    }
    if($userBases){
        echo "<h4>客户基本信息：</h4>";
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
    }
    
    if($certBases){
        echo "<h4>认证基本信息：</h4>";
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
        
        echo $cbHtml;
    }
    
    
    if($certFiles){
        $tableType = 'certfile';
        echo "<h4>扫描文件信息：</h4>";
        $fileHtml = "";
        $cfHtml = "<table width='500'>";
        foreach ($certFiles as $certFile){
            $cfHtml .= "<tr>";
            $cfHtml .= "<td width='200'>文件名称：{$certFile['file_type_id']}</td>";
            $cfHtml .= "<td width='200'>";
            $cfHtml .= "<a href='#'><input id='file_{$certFile['id']}' type='button' value='查看'></a>";
            $cfHtml .= "</td>";
            $cfHtml .= "</tr>";
            
            $fileHtml .= "<div id='img_{$certFile['id']}'>";
            $fileHtml .= "<img width='450' height='530' src='{$base_url}include/images/{$certFile['file_name']}'/>";
            $fileHtml .= "</div>"; 
            
        }
        $cfHtml .= '</table><br>';
        
        echo $cfHtml; 
        echo $fileHtml;
        
    }
      
    
    if($certContents){
        $tableType = 'certcontent';
        echo "<h4>文字类信息：</h4>";
        $ccHtml = "<table width='500'>";
        $contentHtml = '';
        foreach ($certContents as $certContent){
            $ccHtml .= "<tr>";
            $ccHtml .= "<td width='200'>文件名称：{$certContent['title']}</td>";
            $ccHtml .= "<td width='200'>";
            $ccHtml .= "<a href='#'><input id='content_{$certContent['id']}' type='button' value='查看'></a>";
            $ccHtml .= "</td>";
            $ccHtml .= "</tr>";
            
            $contentHtml .= "<div id='detail_{$certContent['id']}'>";
            $contentHtml .= "标题：{$certContent['title']}<br>";
            $contentHtml .= "内容：{$certContent['content']}<br>";
            $contentHtml .= "</div>";
        }
        $ccHtml .= '</table><br>';
        
        echo $ccHtml; 
        echo $contentHtml;
    }
    