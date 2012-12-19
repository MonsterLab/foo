<div>
    <h2>修改认证文字类信息</h2>
</div>
<?php
    $base_url = base_url();
    if($flag != ''){
        echo $flag;
        exit();
    }
?>  
<div>
    <form action="<?php echo base_url("admin/updateCertContent/{$certContent[0]['id']}/$type/{$certContent[0]['uid']}") ?>" method='post'>
        <p>
            <label for="title">认证题目:</label>
            <input type='text' id="title" name='title' value='<?= $certContent[0]['title']?>'><br>
        </p>        
        <p>
            <label for="content">认证内容:</label>
            <?
                $conText = $certContent[0]['content'];
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