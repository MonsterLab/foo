<body>

<div>
    <h2>修改认证扫描件信息</h2>
</div>
<?php
    $base_url = base_url();
    if($flag != ''){
        echo $flag;
        exit();
    }
?>    

<div>    
    <form action='<?php echo base_url("admin/updateCertFile/{$fileId}/{$fileTypeId}/{$type}/$uid")?>' method='post' enctype='multipart/form-data'>

        证书名：<?= $fileTypeName?>
        <br/>
        上传文件：<input type='file' name='file' value='' /><br>
        <input type='submit' name='submit' value='上传'/>
    </form>
</div>    
        
</body>