        <div id="content">
            <div id="infoList">
                <h3><?php echo $guide;?></h3>
                <?php 
                    echo $articlesHtml;
                    echo $pageBar;
                ?>
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
