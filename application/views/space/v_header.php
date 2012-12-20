<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
             <link href="<?php echo base_url("include/css/client/cms_client.css");?>" type="text/css" rel="stylesheet"/>
            <link href="<?php echo base_url("include/css/client/space_client.css");?>" type="text/css" rel="stylesheet"/>
            <link href="<?php echo base_url("include/css/client/slidedown.css");?>" type="text/css" rel="stylesheet"/>                                                                                                                   
            <script src="<?php echo base_url('include/js/jquery-1.3.1.min.js');?>" type="text/javascript"></script>
            <script src="<?php echo base_url("include/js/index.js");?>" type="text/javascript" ></script>
        <title></title>
    </head>
    <body>
        <div id="header">
            <h1>中国经济网<span>——注册空间</span></h1>
            <h2>注册法人：<?php echo '<a href="'.base_url('space/edit/'.$uid).'">'.$username.'</a>';?></h2>
            <?php echo $nav;?>
        </div>