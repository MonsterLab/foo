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
                        <dd><a href="<?php echo base_url('admin/searchAdmins');?>" target="main">管理用户管理</a></dd>
                        <dd><a href="<?php echo base_url('admin/searchUsers');?>" target="main">客户管理</a></dd>
                    </dl>
                </li>
                <li>
                    <dl>
                        <dt>综合信息管理</dt>
                        <dd>
                            <a>栏目管理</a>
                            <ul>
                                <li><a href="<?php echo base_url('admin/createGroup');?>" target="main">添加栏目</a></li>
                                <li><a href="<?php echo base_url('admin/manageGroup');?>" target="main">管理栏目</a></li>
                            </ul>
                        </dd>
                        <dd>
                            <a>文章管理</a>
                            <ul>
                                <li><a href="<?php echo base_url('admin/createArticle');?>" target="main">添加文章</a></li>
                                <li><a href="<?php echo base_url('admin/manageArticle');?>" target="main">管理文章</a></li>
                            </ul>
                        </dd>
                        <dd>
                            <a>用户空间管理</a>
                            <ul>
                                <li><a href="<?php echo base_url('admin/createSArticle');?>" target="main">添加空间文章</a></li>
                                <li><a href="<?php echo base_url('admin/manageSArticle');?>" target="main">管理空间文章</a></li>
                                <li><a href="<?php echo base_url('admin/createSGroup');?>" target="main">添加空间分组</a></li>
                                <li><a href="<?php echo base_url('admin/manageSGroup');?>" target="main">管理空间分组</a></li>
                            </ul>
                        </dd>
                    </dl>
                </li>
                <li>
                    <dl>
                        <dt>征信库管理</dt>
                        <dd><a href="<?= base_url('admin/searchCode')?>" target="main">征信编码池管理</a></dd>
                        <dd><a href="<?= base_url('admin/searchUsers/topic')?>" target="main">纳税主体征信库</a></dd>
                        <dd><a href="<?= base_url('admin/searchUsers/medium')?>" target="main">中介机构征信库</a></dd>
                        <dd><a href="<?= base_url('admin/searchUsers/talent')?>" target="main">财税个人征信库</a></dd>
                        <dd><a href="<?= base_url('admin/searchFileType')?>" target="main">具体征信项目设置</a></dd>
                        <dd><a href="<?= base_url('admin/searchIndustry')?>" target="main">行业分类设置</a></dd>
                    </dl>
                </li>
            </ul>         
        </div>
    </body>
</html>
