<html>
<head>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
</head>
<body>
    <?php
        $base_url = base_url();
        /**
        * 弹出提示信息
        */
       if($flag != ''){
           echo "<script>alert('{$flag}');window.location='{$base_url}admin/importCode/';</script>";
           exit();
       }
    ?>
    <form action="<?php echo base_url('admin/importCode')?>" method="post" enctype="multipart/form-data">
	<input type="file" name="file" /><br />
	<input type="submit" value="提交" name="submit">
    </form>
</body>
</html>