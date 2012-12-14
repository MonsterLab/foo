<div>
    <h2>添加认证扫描件信息</h2>
</div>
<?php
//addCertFile($cuid,$uid,$file_type_id,$file_name)
    $base_url = base_url();
    if($flag != ''){
        echo $flag;
        exit();
    }
    
    echo "<form action='{$base_url}index.php/admin/addCertFile/{$type}/{$uid}' method='post' enctype='multipart/form-data'>";
    echo "证书名：";
    echo "<select name='filename'>";
    foreach ($fileTypes as $fileType){
        echo "<option value='{$fileType['id']}'>{$fileType['file_name']}</option>";
    }
    echo "</select><br>";
    echo "上传文件：<input type='file' name='file' value='' /><br>";
    echo "<input type='submit' name='submit' value='上传'>";
    echo "</form>";