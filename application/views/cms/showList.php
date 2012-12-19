        <div id="content">
            <div id="infoList">
                <h3><?php echo $guide;?></h3>
                <?php 
                    echo $articlesHtml;
                    echo $pageBar;
                ?>
            </div>
            <div id="column1">
                <h3>中心简介</h3>
                <?php echo $rightColumn['zxjj']; ?>
            </div>
            <div id="column2">
                <h3>征信范围</h3>
                <?php echo $rightColumn['zxfw'];?>
            </div>
            <div id="column3">
                <h3>办事流程</h3>
                <?php echo $rightColumn['bslc'];?>
            </div>
        </div>

