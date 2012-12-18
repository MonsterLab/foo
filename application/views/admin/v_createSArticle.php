<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <link href="<?php echo base_url("include/css/admin.css");?>" type="text/css" rel="stylesheet"/>
        <title></title>
    </head>
    <body id="createArticle-body">
        <div id="createArticle">
            <form action="<?php echo base_url('admin/createSArticle?uid='.$uid) ?>" method="post">
                <?php 
                    if(isset($flag)){
                        echo '<p>'.$message.'</p>';
                    }
                    
                    if(isset($flag) && $flag == 0){
                        $titText = $title;
                        $conText = $content;
                    } else {
                        $titText = '这里填写文章标题';
                        $conText = '这里填写文章内容';
                    }
                ?>
                <p>
                    <label for="groupid">文章分类</label>
                    <select name="space_gid">
                        <?php 
                            foreach ($space_groups as $row){
                                if(isset($flag) && $space_gid == $row['space_gid']){
                                    echo '<option selected="selected" value='.$row['space_gid'].'>'.$row['space_group_name'].'</option>';
                                    continue;;
                                }
                                echo '<option value='.$row['space_gid'].'>'.$row['space_group_name'].'</option>';
                            }
                        ?>
                    </select>
                </p>
                <p>
                    <label for="title">文章标题</label>
                    <input type="text" name="space_title" id ="title" value="<?php echo $titText;?>"/>
                </p>
                <p>
                    <label for="content">文章内容</label>
                    <?
                        $this->load->helper('form_helper');
                        $data = array(
                                      'name'        => 'space_content',
                                      'id'          => 'content',
                                      'toolbarset'  => 'Default',
                                      'basepath'    => '/workspace/foo/include/fckeditor/',
                                      'width'       => '80%',
                                      'height'      => '500'
                            );

                        echo form_fckeditor( $data,$conText); 
                    ?>
                </p>
                <p>
                    <input type="submit" name="sub" id="sub" value="添加文章"/><input type="reset" name="reset" id="reset" value="重填"/>
                </p>
            </form>            
        </div>
    </body>
</html>
