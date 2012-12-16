<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <link href="<?php echo base_url("include/css/admin.css");?>" type="text/css" rel="stylesheet"/>
            <script src="<?php echo base_url('include/js/jquery-1.7.2.js');?>" type="text/javascript"></script>
            <script src="<?php echo base_url('include/js/json2.js');?>" type="text/javascript"></script>
        <title></title>
        <script type="text/javascript">
            $(function(){
                var $selectGroup = $("#groupid");
                $base = "<?php echo base_url('admin/manageArticle?groupid='); ?>";
                $selectGroup.change(function(){
                    $url = $base+$(this).val();
                    $.ajax({
                        type:"post",
                        data:'',
                        url:$url,
                        success:function(data)
                        {
                            var result = JSON.parse(data);
                            
                            $('#groupid').html(null);
                            $('#groupid').html(result.groupsHtml);
                            $('#content table').html(null);
                            $('#content table').html(result.articleHtml);
                            $('#pageBar').html(null);
                            $('#pageBar').html(result.pageBar);
                        },

                        error:function()
                        {
                             $("#loading_message").hide();
                        }
                     });

                 });

            });
                    
        </script>
    </head>
    <body id="manageArticle-body">
        <div id="manageArticle">
            <div id="title">
                <h2>管理文章</h2>
                <ul>
                    <li>文章须经过审核才能在主页显示,审核文章需点击查看后才能审核</li>
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
