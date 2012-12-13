<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="<?php echo base_url("include/css/admindisp.css");?>" type="text/css" rel="stylesheet"/>
        <title></title>
    </head>
    <body id="menu-body">
        <div id="menu">
            <ul id="mainnav">
                <li>
                    <dl>
                        <dt>用户管理</dt>
                        <dd><a href="">管理用户管理</a></dd>
                        <dd><a href="">客户管理</a></dd>
                    </dl>
                </li>
                <li>
                    <dl>
                        <dt>综合信息管理</dt>
                        <dd>
                            <a href="">栏目管理</a>
                            <ul>
                                <li><a href="<?php echo base_url('admin/createGroup');?>">添加栏目</a></li>
                                <li><a href="<?php echo base_url('admin/manageGroup');?>">管理栏目</a></li>
                            </ul>
                        </dd>
                        <dd>
                            <a href="" target="main">文章管理</a>
                            <ul>
                                <li><a href="<?php echo base_url('admin/createArticle');?>">添加文章</a></li>
                                <li><a href="<?php echo base_url('admin/manageArticle');?>">管理文章</a></li>
                            </ul>
                        </dd>
                        <dd>
                            <a href="" target="main">用户空间管理</a>
                            <ul>
                                <li><a href="">添加空间文章</a></li>
                                <li><a href="">管理空间文章</a></li>
                            </ul>
                        </dd>
                    </dl>
                </li>
                <li>
                    <dl>
                        <dt>征信库管理</dt>
                        <dd><a href="">征信编码池管理</a></dd>
                        <dd><a href="">纳税主体征信库</a></dd>
                        <dd><a href="">中介机构征信库</a></dd>
                        <dd><a href="">财税个人征信库</a></dd>
                        <dd><a href="">具体征信项目设置</a></dd>
                        <dd><a href="">行业分类设置</a></dd>
                    </dl>
                </li>
            </ul>         
        </div>
    </body>
</html>
