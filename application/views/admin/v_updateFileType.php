<?php
    /**
    * 弹出提示信息
    */
    $base_url = base_url();
   if($flag != ''){
       echo "<script>alert('{$flag}');window.location='{$base_url}admin/updateFileType/{$fid}';</script>";
       exit();
   }
?> 

<div>
    <h2>添加具体项目类型</h2>
</div>

<div>
    <form action="<?php echo base_url("admin/updateFileType/{$fid}") ?>" method='post'>
        <p>
            <label for="type">所属征信库：</label>
            <input type="text" id="type" name="type" value="<?= $type?>" readonly/>
        </p>    
        <p>
            <label for="filename">扫描件标题：</label>
            <input type="text" id="filename" name="filename" value="<?= $fileName?>"/>
        </p>
        <p>
            <input type='submit' name='submit' value='提交'>
        </p> 
    </form>
</div>