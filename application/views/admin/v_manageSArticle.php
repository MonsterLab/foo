<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <link href="<?php echo base_url("include/css/admin.css");?>" type="text/css" rel="stylesheet"/>
        <title></title>
    </head>
    <body id="manageArticle-body">
        <div id="manageArticle">
            <div id="title">
                <h2>管理用户空间文章</h2>
                <ul>
                    <li>文章须经过审核才能在主页显示</li>
                    <li>文章删除后，文章不可见，但还存在于数据库中</li>
                </ul>                    
            </div>
            <div id="content">
                <p><label for="groupid">文章分类选择：</label>
                    <?php echo $groupsHtml;?>
                </p>
                <?php 
                    echo $articleHtml;
                    echo $pageBar;
                ?>
            </div>
        </div>
        

    </body>
</html>
