        <div id="content">
            <div id="infoList">
                <h3><?php echo $guide;?></h3>
                <div id="article">
                    <h3><?php echo $article[0]['space_title'];?></h3>
                    <p><?echo $article[0]['space_ctime'].'   作者：'.$article[0]['space_username'];?> </p>
                    <div id="arContent">
                    <?echo $article[0]['space_content'];?>
                    </div>
                </div>
            </div>
            <div id="column1">
                <h3>公司展示</h3>
                <?php echo $column['gszs']; ?>
            </div>
            <div id="column2">
                <h3>人力资源</h3>
                <?php echo $column['rlzy']; ?>
            </div>
            <div id="column3">
                <h3>最新报导</h3>
                <?php echo $column['zxbd']; ?>
            </div>
        </div>