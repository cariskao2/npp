<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH . '/libraries/FendBaseController.php';

class News_f extends FendBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('website_model');
        $this->load->model('news_f_model');
        $this->global['getSetupInfo'] = $this->website_model->getSetupInfo();
        $this->global['navActive']    = 1;
        // $this->isLoggedIn();
    }

    public function pageNotFound()
    {
        $this->global['pageTitle'] = 'CodeInsect : 404 - Page Not Found';

        $this->loadViews("404", $this->global, null, null);
    }

    // 新聞訊息首頁
    public function index()
    {
        $this->global['pageTitle'] = '新聞訊息 - 時代力量立法院黨團';

        $data = array(
            'get1Info' => $this->news_f_model->getNewsInfo(1),
            'get2Info' => $this->news_f_model->getNewsInfo(2),
            'get3Info' => $this->news_f_model->getNewsInfo(3),
        );

        $this->loadViews("fend/news/news", $this->global, $data, null);
    }

    /*
    ##       ####  ######  ########
    ##        ##  ##    ##    ##
    ##        ##  ##          ##
    ##        ##   ######     ##
    ##        ##        ##    ##
    ##        ##  ##    ##    ##
    ######## ####  ######     ##
     */

    // 新聞訊息的各項列表
    public function newsFlists($type_id)
    {
        switch ($type_id) {
            case '1':
                $this->global['pageTitle']     = '法案及議事說明 - 時代力量立法院黨團';
                $this->global['breadcrumbTag'] = '法案及議事說明';
                break;
            case '2':
                $this->global['pageTitle']     = '懶人包及議題追追追 - 時代力量立法院黨團';
                $this->global['breadcrumbTag'] = '懶人包及議題追追追';
                break;
            case '3':
                $this->global['pageTitle']     = '行動紀實 - 時代力量立法院黨團';
                $this->global['breadcrumbTag'] = '行動紀實';
                break;
        }

        $searchFrom = $this->security->xss_clean($this->input->post('searchFrom'));
        $searchEnd  = $this->security->xss_clean($this->input->post('searchEnd'));
        $searchKey  = $this->security->xss_clean($this->input->post('searchKey'));

        // 回傳前台的搜尋欄位
        $data = array(
            'searchFrom' => $searchFrom,
            'searchEnd'  => $searchEnd,
            'searchKey'  => $searchKey,
        );

        $count = $this->news_f_model->listingCount($searchFrom, $searchEnd, $searchKey, $type_id); //算出總筆數
        // echo ' count: ' . $count;

        //記得加上「/」
        // paginationCompress好像要配合前台的form才有作用
        // 當使用__CLASS__跟__FUNCTION__時,若檔案放在controller目錄的一個子目錄下,獲取的url會吃不到子目錄名稱
        // $siteUrl = site_url(strtolower(__CLASS__) . '/' . __FUNCTION__);
        // $returns = $this->paginationCompress(site_url($siteUrl, $count, 12, 5);
        $returns = $this->paginationCompress("fend/news_f/newsFlists/" . $type_id . '/', $count, 12, 5);
        // echo ' segment-News: ' . $returns['segment'];

        $data['listItems'] = $this->news_f_model->listing($searchFrom, $searchEnd, $searchKey, $type_id, $returns["page"], $returns["segment"]);
        $data['type_id']   = $type_id; //用來帶入newsLists_f中searchText的form action

        $this->loadViews("fend/news/newsLists_f", $this->global, $data, null);
    }

    // tags列表
    public function tagsList($tag_id)
    {
        $count = $this->news_f_model->tagslistingCount($tag_id);
        // echo ' count: ' . $count . '<br>';
        $returns = $this->paginationCompress("fend/news_f/tagsList/" . $tag_id . '/', $count, 5, 5);
        // echo ' segment-News: ' . $returns['segment'];
        $data['tagsList'] = $this->news_f_model->tagsListing($tag_id, $returns["page"], $returns["segment"]);

        foreach ($data['tagsList'] as $k => $v) {
            $name = $v->name;
        }

        $this->global['pageTitle']     = $name . ' - 新聞訊息 - 時代力量立法院黨團';
        $this->global['breadcrumbTag'] = $name;

        $this->loadViews("fend/news/tagsList_f", $this->global, $data, null);
    }

/*
.####.##....##.##....##.########.########.
..##..###...##.###...##.##.......##.....##
..##..####..##.####..##.##.......##.....##
..##..##.##.##.##.##.##.######...########.
..##..##..####.##..####.##.......##...##..
..##..##...###.##...###.##.......##....##.
.####.##....##.##....##.########.##.....##
 */
    public function newsInner($type_id, $id)
    {
        // 在views使用?xx=xx
        // $id      = $this->input->get('d');
        // $type_id = $this->input->get('t');

        $data = array(
            'getInnerInfo'  => $this->news_f_model->getInnerInfo($id),
            'innerPrevNews' => $this->news_f_model->innerPrevNews($type_id, $id),
            'innerNextNews' => $this->news_f_model->innerNextNews($type_id, $id),
            'getTagsChoice' => $this->news_f_model->getTagsChoice($id),
        );

        foreach ($data['getInnerInfo'] as $k => $v) {
            if ($k == 'pr_type_id') {
                $t = $v;
            }
            if ($k == 'pr_id') {
                $d = $v;
            }
            if ($k == 'main_title') {
                $this->global['pageTitle'] = $v;
            }
        }

        if ($t != $type_id || $d != $id) {
            redirect('fend/news_f?b=true');
        }

        switch ($type_id) {
            case '1':
                $this->global['breadcrumbTag'] = '法案及議事說明';
                break;
            case '2':
                $this->global['breadcrumbTag'] = '懶人包及議題追追追';
                break;
            case '3':
                $this->global['breadcrumbTag'] = '行動紀實';
                break;
        }

        $this->loadViews("fend/news/newsInner", $this->global, $data, null);
    }
}
