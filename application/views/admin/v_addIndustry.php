<?php
    /**
    * 弹出提示信息
    */
    $base_url = base_url();
   if($flag != ''){
       echo "<script>alert('{$flag}');window.location='{$base_url}admin/addIndustry/';</script>";
       exit();
   }
?> 

<div>
    <h2>添加具体项目类型</h2>
</div>

<div>
    <form action="<?php echo base_url("admin/addIndustry") ?>" method='post'>
        <p>
            <label for="type">选择征信库：</label>
            <select name="type">
                <option value="topic">纳税主体</option>
                <option value="medium">中介机构</option>
                <option value="talent">财税人才</option>
            </select><br/>
        </p>    
        <p>
            <label for="industryName">行业分类：</label>
            <input type="text" id="industryName" name="industryName" value=""/>
        </p>
        <p>
            <input type='submit' name='submit' value='提交'>
        </p> 
    </form>
</div>