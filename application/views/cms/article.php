<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <link href="<?php echo base_url("include/css/client/cms_client.css");?>" type="text/css" rel="stylesheet"/>
        <title></title>
    </head>
    <body>
        <div id="header">
            <h1>中国经济网</h1>
            <ul>
                <li><a href="">导航1</a></li>
                <li><a href="">导航1</a></li>
                <li><a href="">导航1</a></li>
                <li><a href="">导航1</a></li>
                <li><a href="">导航1</a></li>
                <li><a href="">导航1</a></li>
                <li><a href="">导航1</a></li>
                <li><a href="">导航1</a></li>
                <li><a href="">导航1</a></li>                
            </ul>
        </div>
        <div id="content">
            <div id="infoList">
                <h3><?php echo $guide;?></h3>
                <div id="article">
                    <h3><?php echo $article[0]['title'];?></h3>
                    <p id="author"><?echo $article[0]['ctime'].'   作者：'.$article[0]['username'];?> </p>
                    <div id="arContent">
                    <?echo $article[0]['content'];?>
                    </div>
                </div>
            </div>
            <div id="column1">
                sdfs
            </div>
            <div id="column2">
                sfsf
            </div>
            <div id="column3">
                dfsd
            </div>
        </div>
        <div id="line_10"></div>
        <div id="footer">
            版权所有&copy中国财经网
        </div>

        

    </body>
</html>
