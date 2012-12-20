<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>中国经济网 信用频道</title>
<script src="<?php echo base_url('include/js/jquery-1.3.1.min.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('include/js/showPic.js')?>" type="text/javascript"></script>
</head>
<body>
<div id="content">
    <div id="infoList_two">
<?php
    
//    echo '<pre>';
//    print_r($certFiles);
//    echo '</pre>';
    
    $base_url = base_url();
    
    if($userBases){
        echo "<p style='font-size:20;color:brown'>客户基本信息：</p>";
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
            
        }  elseif($userBases[0]['audit'] == 0) {
            echo "客户认证基本信息未审核！";
        } elseif ($userBases[0]['audit'] == -1) {
            echo "客户认证基本信息审核未通过！";
        }
    }
    
    if($certBases){
        echo "<p style='font-size:20;color:brown'>认证基本信息：</p>";
        //判断认证基本信息是否审核
        if($certBases[0]['audit'] == 1){
            $cbHtml = "<table width='550'>";
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
                    $cbHtml .= "<td width='600'>征信期限：{$certBase['cert_begin']}~{$certBase['cert_end']}</td>";
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
            
        } elseif($certBases[0]['audit'] == 0) {
            echo "客户认证基本信息未审核！";
        } elseif ($certBases[0]['audit'] == -1) {
            echo "客户认证基本信息审核未通过！";
        }
    }
    
    if($certFiles){
        echo "<p style='font-size:20;color:brown'>扫描件信息：</p>";
        $cfHtml = "<table width='500'>";
        foreach ($certFiles as $certFile){
            $cfHtml .= "<tr>";
            $cfHtml .= "<td width='200'>文件名称：{$certFile['file_type_name']}</td>";
            $cfHtml .= "<td width='200'>";
            $cfHtml .= "<img width='450' height='530' style='display:none' src='{$base_url}include/images/{$certFile['file_name']}'/>";
            if($certFile['audit'] == 1){
                $cfHtml .= "<input type='button' class='showPic_button' value='查看'>";
            }  elseif($certFile['audit'] == 0) {
                $cfHtml .= "未审核";
            }  elseif($certFile['audit'] == -1) {
                $cfHtml .= "审核未通过";
            }
            $cfHtml .= "</td>";
            $cfHtml .= "</tr>";
        }
        $cfHtml .= '</table><br>';

        echo $cfHtml; 
    }
      
    
    if($certContents){
            echo "<p style='font-size:15;color:brown'>文字类信息：</p>";
            $cfHtml = "<table width='500'>";
            foreach ($certContents as $certContent){
                $cfHtml .= "<tr>";
                $cfHtml .= "<td width='200'>标题：{$certContent['title']}</td>";
                $cfHtml .= "<td width='200'>";
                if($certContent['audit'] == 1){
                    $cfHtml .= "<a href='{$base_url}search/showContent/{$type}/{$certContent['uid']}'><input type='button' value='查看'>";
                }  elseif($certContent['audit'] == 0) {
                    $cfHtml .= "未审核";
                }  elseif($certContent['audit'] == -1) {
                    $cfHtml .= "审核未通过";
                }
                    $cfHtml .= "</td>";
                    $cfHtml .= "</tr>";
                }
            $cfHtml .= '</table><br>';

            echo $cfHtml; 
        
    }
?> 
    <div>
        <p style='font-size:20;color:brown'>客户空间：</p>
        <?php 
            if($userBases[0]['space_id'] > 0){
                echo "详细信息，请<a href='#'>查看客户空间</a>";
            }  else {
                echo "该客户尚未开通空间！";
            }
        ?>
    </div>
</div>        
</div>        
</body>
</html>