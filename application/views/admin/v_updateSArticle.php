<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <link href="<?php echo base_url("include/css/admin.css");?>" type="text/css" rel="stylesheet"/>
        <title></title>
    </head>
    <body id="createArticle-body">
        <div id="createArticle">
            <form action="<?php echo base_url('admin/updateSArticle?space_aid='.$space_aid) ?>" method="post">
                <?php 
                    if(isset($flag)){
                        echo '<p>'.$message.'</p>';
                    }
                ?>
                <p>
                    <label for="groupid">文章分类</label>
                    <select name="space_gid">
                        <?php 
                            foreach ($space_groups as $row){
                                if($space_gid == $row['space_gid']){
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
                    <input type="text" name="space_title" id ="title" value="<?php echo $space_title;?>"/>
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

                        echo form_fckeditor( $data,$space_content); 
                    ?>
                </p>
                <p>
                    <input type="submit" name="sub" id="sub" value="修改文章"/><input type="reset" name="reset" id="reset" value="重填"/>
                </p>
            </form>            
        </div>
    </body>
</html>
