<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <link href="<?php echo base_url("include/css/admin.css");?>" type="text/css" rel="stylesheet"/>
        <title></title>
        <script src="<?php echo base_url('include/js/jquery-1.7.2.js');?>" type="text/javascript"></script>
        <script type="text/javascript">
            function alert_deleteGroup(gid){
                var r = confirm("删除分类，会删除其子类，是否删除?");
                if(r == true){
                    url = "<?php echo base_url('admin/deleteGroup?gid=');?>"+gid;
                    window.location.href = url;
                }
            }
            
            function alert_deleteSGroup(space_gid){
                var r = confirm("删除分类，会删除其子类，是否删除?");
                if(r == true){
                    url = "<?php echo base_url('admin/deleteSGroup?space_gid=');?>"+space_gid;
                    window.location.href = url;
                }
            }
            
        </script>
    </head>
    <body id="manageGroup-body">
        <div id="manageGroup">
            <h2>管理栏目分类</h2>
            <?php echo $groupsHtml;?>
        </div>
    </body>
</html>
