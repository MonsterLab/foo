<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <link href="<?php echo base_url("include/css/admin.css");?>" type="text/css" rel="stylesheet"/>
        <title></title>
    </head>
    <body id="createArticle-body">
        <div id="createArticle">
            <form action="<?php echo base_url('admin/updateArticle?aid='.$aid) ?>" method="post">
                <?php 
                    if(isset($flag)){
                        echo '<p>'.$message.'</p>';
                    }
                ?>
                <p>
                    <label for="groupid">文章分类</label>
                    <select name="gid">
                        <?php 
                            foreach ($groups as $row){
                                if($groupid == $row['gid']){
                                    echo '<option selected="selected" value='.$row['gid'].'>'.$row['group_name'].'</option>';
                                    continue;;
                                }
                                echo '<option value='.$row['gid'].'>'.$row['group_name'].'</option>';
                            }
                        ?>
                    </select>
                </p>
                <p>
                    <label for="title">文章标题</label>
                    <input type="text" name="title" id ="title" value="<?php echo $title;?>"/>
                </p>
                <p>
                    <label for="content">文章内容</label>
                    <?
                        $this->load->helper('form_helper');
                        $data = array(
                                      'name'        => 'content',
                                      'id'          => 'content',
                                      'toolbarset'  => 'Default',
                                      'basepath'    => '/workspace/foo/include/fckeditor/',
                                      'width'       => '80%',
                                      'height'      => '500'
                            );

                        echo form_fckeditor( $data,$content); 
                    ?>
                </p>
                <p>
                    <input type="submit" name="sub" id="sub" value="修改文章"/><input type="reset" name="reset" id="reset" value="重填"/>
                </p>
            </form>            
        </div>
    </body>
</html>
