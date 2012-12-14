<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <link href="<?php echo base_url("include/css/admin.css");?>" type="text/css" rel="stylesheet"/>
        <title></title>
    </head>
    <body id=userspaceList-body">
        <div id="userspaceList">   
            <form action="" method="post">
                <p>
                    <h3>搜索用户</h3>
                    <label for="username">按用户名查询</label>
                    <input type="radio" name="search" value="username" id="username" checked="checked"class="txt"/>
                    <label for="zx_code">按征信编码查询</label>
                    <input type="radio" name="search" value="zx_code" id="zx_code" class="txt"/>
                    <label for="type">按客户征信库类型搜索</label>
                    <input type="radio" name="search" value="type" id="type" class="txt"/>
                </p>
                <p>
                    <input type="text" name="key" value="搜索关键字" class="txt"/>                    
                    <input type="submit" name="sub" id="sub" value="搜索"/> 
                </p>
                                                         
            </form>
            <?php
                echo $userlistHtml;
                echo $pageBar;
            ?>
                
        </div>
    </body>
</html>
