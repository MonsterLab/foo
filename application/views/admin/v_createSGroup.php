<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <link href="<?php echo base_url("include/css/admin.css");?>" type="text/css" rel="stylesheet"/>
        <title></title>
    </head>
    <body id="createGroup-body">
        <div id="createGroup">
            <h2>添加一个新的文章分组</h2>
            <div id="content">
                <form action="<?php echo base_url('admin/createSGroup'); ?>" method="post">
                    <?php 
                        if(isset($flag)){
                            echo '<p>'.$message.'</p>';
                        }

                        if(isset($flag) && $flag == 0){
                            $group_nameText = $group_name;
                            $group_urlText = $group_url;
                            $group_summaryText = $group_summary;
                        } else {
                            $group_nameText = '';
                            $group_urlText = '';
                            $group_summaryText = '';
                        }
                    ?>
                    <p>
                        <label for="groupfather_id">选择所属上级分类</label>
                        <?php echo $groupsHtml; ?>
                    </p>
                    <p>
                        <label for="group_name">分类名称：</label>
                        <input type="text" name="group_name" id="group_name" value="<?php echo $group_nameText;?>"/>
                    </p>
                    <p>
                        <label for="group_url">分类名称首字母缩写</label>
                        <input type="text" name="group_url" id="group_url" value="<?php echo $group_urlText;?>"/>
                    </p>
                    <p>
                        <label for="group_summary">分类描述信息</label>
                        <textarea name="group_summary" id="group_summary" cols="50" rows="5"><?php echo $group_summaryText;?></textarea>                            
                    </p>
                    <p>
                        <input type="submit" name="sub" value="添加分组" id="sub"/>
                        <input type="reset" name="res" value="重填" id="res"/>
                    </p>
                </form>
            </div>
        </div>
        

    </body>
</html>

