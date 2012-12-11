<?php
/**
 * this is a page class
 * Use:
 *      first:
 *          Page $page = new Page($allRows [, $offset]);
 *      second:
 *          $limit = $page->getLimit();
 *          $offset = $page->getOffset();
 *          $data = $this->db->getRecords($key,$limit,$offset);
 *      third:
 *          $pageBar = $page->getPage($data);
 *      forth:
 *          echo $pageBar;
 */
class Page{
            
    private $allRows;//总的记录数        
    private $limit = 0; //起始位置，默认是0
    private $offset = 10;//每页应显示行数
    private $totalPages = 0;//总的页数
    private $currentPage = 1; //当前的第几页
    private $curPageCount;  //当前页实际显示的行数
    private $result = null; //返回的分页数据
    private $from;          //本页从第几条开始
    private $to;            //本页显示到第几条 
    private $last;
    private $next;
    private $lastStyle;
    private $nextStyle;

    /**
     * this method is a constructor of the page ,which is used 
     * for init the total records 'allRows' and the count of listed data
     * @param type $allRows
     * @param type $offset
     */
    public function __construct($allRows = 100, $offset = 10) {
        $this->allRows = $allRows;
        $this->offset = $offset;
        $this->init();
    }
    
    /**
     * this method is used for init the value of 'totalPages' and 'limit'
     */
    private function init(){
        $this->totalPages = ceil(($this->allRows) / ($this->offset));
        if(isset($_GET['page'])){
            if($_GET['page'] > $this->totalPages){        //当输入的页大于总的页数时，等于总的页数
                $this->limit = ($this->totalPages - 1) * $this->offset;
            } else {
                $this->limit = ($_GET['page'] - 1) * $this->offset;
            }
        }
    }
    
    /**
     * this method is used for get the value of 'limit'
     * @return limit
     */
    public function getLimit(){
        return $this->limit;
    }
    
    /**
     * this method is used for get the value  of 'offset'
     * @return offset
     */
    public function getOffset(){
        return $this->offset;
    }
    
    public function getCurrentPage(){
        return $this->currentPage;
    }

    /**
     * this method is the interface for page ,it returns the page bar
     * @param type the input data set is the result of the search list each time.
     * @return the page bar.
     */
    public function getPage($data){
        $this->curPageCount = count($data);
        $this->from = $this->limit;                             //从limit开始
        $this->to = $this->limit + $this->curPageCount;               //到limit + 当前的页面的数量
        if(isset($_GET['page'])){
            if($_GET['page'] > $this->totalPages){        //当输入的页大于总的页数时，等于总的页数
                $this->currentPage = $this->totalPages;
            } else {
                $this->currentPage = $_GET['page'];
            }
        }
        $this->last = $this->currentPage - 1;   //上一页        
        $this->next = $this->currentPage + 1;   //下一页
        
        $this->lastStyle = 'display:inline'; //上一页显示todo
        $this->nextStyle = 'display:inline'; //下一页显示todo
        
        if($this->last < 1){
            $this->last = 1;
            $this->lastStyle = 'display:none';
        }
        
        if($this->next > $this->totalPages){
            $this->next = $this->totalPages;
            $this->nextStyle = 'display:none';
        }
        return $this->getPageBar();
    }
    
    /**
     * this method is used for making page list bar
     * @return the page list bar
     */
    private function getPageBar(){
        //共1条记录 本页1条记录 本页从1 - 1 条 1/1页 第一页 下一页 最后一页
        $result = '<div id="pageBar">';
        $result .= '<form action="'.base_url('admin/manageArticle').'">';
        $result .= '共'.$this->allRows.'条记录  ';
        $result .= '本页'.$this->curPageCount.'条记录  ';
        $result .= '本页从'.$this->from.' - '.$this->to.' 条  ';
        $result .= $this->currentPage.'/'.$this->totalPages.'页  ';
        $result .= '<a href="'.base_url('admin/manageArticle?page=1').'">第一页</a>  ';
        $result .= '<a style="'.$this->lastStyle.'" href="'.base_url('admin/manageArticle?page='.$this->last.'').'">上一页</a>  ';
        $result .= '<a style="'.$this->nextStyle.'" href="'.base_url('admin/manageArticle?page='.$this->next.'').'">下一页</a>  ';
        $result .= '<a href="'.base_url('admin/manageArticle?page='.$this->totalPages.'').'">最后一页</a>  ';
        $result .= '<input type="text" name="page" size="1"/>';
        $result .= '<input type="submit" name="sub" value="GO"/>';
        $result .= '</form>';
        $result .= '</div>';
        
        return $result;
    }
}
