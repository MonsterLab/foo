        <div id="content">
            <div id="infoList">
                <h3><?php echo $guide;?></h3>
                <div id="article">
                    <h3><?php echo $article[0]['title'];?></h3>
                    <p id="author"><?echo $article[0]['ctime'].'   作者：'.$article[0]['username'];?> </p>
                    <div id="arContent">
                    <?echo $article[0]['content'];?>
                    </div>
                </div>
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
