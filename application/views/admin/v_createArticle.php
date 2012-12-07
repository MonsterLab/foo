<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <link href="<?php echo base_url("include/css/admin.css");?>" type="text/css" rel="stylesheet"/>
        <title></title>
    </head>
    <body id="createArticle-body">
        <div id="createArticle">
            <form action="" method="">
                <p>
                    <label for="groupid">文章分类</label>
                    <select>
                        <?php
                            print_r($groups);
//                            foreach ($groups as $group){
//                                echo '<option'.$group->gid.'>'.$group->group_name.'</option>';
//                            }
                        
                        ?>
    
                    </select>
                </p>
                <p>
                    <label for="title">文章标题</label>
                    <input type="text" name="title" id ="title"value="这里填写文章标题"/>
                </p>
                <p>
                    <label for="content">文章内容</label>
                    <textarea rows="20" cols="80" name="content" value="这里填写文章内容"></textarea>
                </p>
                <p>
                    <input type="submit" name="sub" id="sub" value="添加文章"/><input type="reset" name="reset" id="reset" value="重填"/>
                </p>
            </form>            
        </div>
    </body>
</html>
