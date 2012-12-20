<head>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
</head>
<?php
    $base_url = base_url();
    if($flag != ''){
        echo $flag;
        exit();
    }
?> 
<div>
    <h2><?= $head?>认证文字类信息</h2>
</div>
 

<div>
    
    <?php
        if($certContents){
            echo "<h5>已提交文字类信息：</h5>";
            $cfHtml = "<table width='500'>";
            $i = 1;
            foreach ($certContents as $certContent){
                $cfHtml .= "<tr>";
                $cfHtml .= "<td width='200'>{$i}、标题：{$certContent['title']}</td>";
                $cfHtml .= "<td width='200'>";
                
                if($handle == 'update'){
                    $cfHtml .= "<a href='{$base_url}admin/updateCertContent/{$certContent['id']}/{$type}/{$uid}'><input type='button' value='查看'></a>";
                    $cfHtml .= "<a href='{$base_url}admin/updateCertContent/{$certContent['id']}/{$type}/{$uid}'><input type='button' value='修改'></a>";
                }elseif ($handle == 'add') {
                    $cfHtml .= "<a href='{$base_url}admin/showContent/{$type}/{$uid}'><input type='button' value='查看'></a>";
                }
                $cfHtml .= "</td>";
                $cfHtml .= "</tr>";
                $i ++ ;
            }
            $cfHtml .= '</table><br>';

            echo $cfHtml; 
        }
    ?>
</div>
<?php if($handle == 'add'){?>
<div>
    <h5>添加:</h5>
    <form action="<?php echo base_url("admin/addCertContent/$type/{$uid}") ?>" method='post'>
        <p>
            <label for="title">认证题目:</label>
            <input type='text' id="title" name='title' value=''><br>
        </p>        
        <p>
            <label for="content">认证内容:</label>
            <?
                $conText = '在这里添加认证内容';
                $this->load->helper('form_helper');
                $data = array(
                              'name'        => 'content',
                              'id'          => 'content',
                              'toolbarset'  => 'Default',
                              'basepath'    => '/workspace/foo/include/fckeditor/',
                              'width'       => '80%',
                              'height'      => '500'
                    );

                echo form_fckeditor( $data,$conText); 
            ?>
        </p>
        <p>
            <input type='submit' name='submit' value='提交'>
        </p>    
    </form>
</div>    
<?php }?>