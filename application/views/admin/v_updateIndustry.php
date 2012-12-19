<?php
    /**
    * 弹出提示信息
    */
    $base_url = base_url();
   if($flag != ''){
       echo "<script>alert('{$flag}');window.location='{$base_url}admin/updateIndustry/{$industryId}';</script>";
       exit();
   }
?> 

<div>
    <h2>修改具体项目类型</h2>
</div>

<div>
    <form action="<?php echo base_url("admin/updateIndustry/{$industryId}") ?>" method='post'>
        <p>
            <label for="type">所属征信库：</label>
            <input type="text" id="type" name="type" value="<?= $type?>" readonly/>
        </p>    
        <p>
            <label for="industryName">行业分类：</label>
            <input type="text" id="industryName" name="industryName" value="<?= $industryName?>"/>
        </p>
        <p>
            <input type='submit' name='submit' value='修改'>
        </p> 
    </form>
</div>