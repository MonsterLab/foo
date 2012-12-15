<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <link href="<?php echo base_url("include/css/admin.css");?>" type="text/css" rel="stylesheet"/>
        <title></title>
    </head>
    <body id="viewArticle-body">
        <div id="viewArticle">
            <p style="padding: 0 0 0 50px;"><?php echo $mess;?></p>
            <div id="audit">
                <form action="<?php echo base_url('admin/auditArticle?aid='.$aid);?>" method="post">
                    <label for="au">审核:</label>
                    <?php echo $selectHtml;?>
                    <input type="submit" name="sub" value="确定"/>
                </form>
            </div>
            <div id="article">
                    <h3><?php echo $article[0]['title'];?></h3>
                    <p><?echo $article[0]['ctime'].'   作者：'.$article[0]['username'];?> </p>
                    <div id="arContent">
                    <?echo $article[0]['content'];?>
                    </div>
            </div>
            
        </div>
    </body>
</html>

