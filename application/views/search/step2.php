<?php
    if($zxcode == 0){
?>
        "您输入的查询信息不存在"
<?php
    } else {
?>
用户:<?php echo $com_name;?><br/>已通过认证
输入授权编码<br/>
<form method="post" action="<?php echo base_url('search/step2/')?>">
    <input type="hidden" name="zxcode" value="<?php echo $zxcode;?>"/>
    <input type="text" name="sqcode" />
    <input type="submit" value="查询" />
</form>
<?php
    }
?>