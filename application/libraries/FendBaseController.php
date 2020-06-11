<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class : FendBaseController
 * Base Class to control over all the classes
 */
class FendBaseController extends CI_Controller
{
    protected $role      = '';
    protected $vendorId  = '';
    protected $name      = '';
    protected $roleText  = '';
    protected $global    = array();
    protected $lastLogin = '';

    /**
     * Takes mixed data and optionally a status code, then creates the response
     *
     * @access public
     * @param array|NULL $data
     *            Data to output to the user
     *            running the script; otherwise, exit
     */
    public function response($data = null)
    {
        $this->output->set_status_header(200)->set_content_type('application/json', 'utf-8')->set_output(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))->_display();
        exit();
    }

    /**
     * This function is used to load the set of views
     */
    public function loadThis()
    {
        $this->global['pageTitle'] = '被拒絕進入';

        $this->load->view('fend/fend_includes/header', $this->global);
        $this->load->view('access');
        $this->load->view('fend/fend_includes/footer');
    }

    /**
     * This function used to load views
     * @param {string} $viewName : This is view name
     * @param {mixed} $headerInfo : This is array of header information
     * @param {mixed} $pageInfo : This is array of page information
     * @param {mixed} $footerInfo : This is array of footer information
     * @return {null} $result : null
     */
    public function loadViews($viewName = "", $headerInfo = null, $pageInfo = null, $footerInfo = null)
    {

        $this->load->view('fend/fend_includes/header', $headerInfo);
        $this->load->view($viewName, $pageInfo);
        $this->load->view('fend/fend_includes/footer', $footerInfo);
    }

    /**
     * This function used provide the pagination resources
     * @param {string} $link : This is page link
     * @param {number} $count : This is page count
     * @param {number} $perPage : This is records per page limit
     * @return {mixed} $result : This is array of records and pagination data
     */
    public function paginationCompress($link, $count, $perPage = 10, $segment = SEGMENT)
    {
        // 需要跟views的$().submit()搭配,所以需要<form id="xx"></form>
        $this->load->library('pagination');

        // 當在controller使用__CLASS__跟__FUNCTION__時,若檔案放在controller目錄的一個子目錄下,獲取的url會吃不到子目錄名稱
        // $config['base_url'] = $link;
        // echo $config['base_url'] . '<br>';

        $config['base_url']        = base_url() . $link;
        $config['total_rows']      = $count;
        $config['uri_segment']     = $segment;
        $config['per_page']        = $perPage;
        $config['num_links']       = 5;
        $config['full_tag_open']   = '<nav class="pagination-f"><ul class="pagination">';
        $config['full_tag_close']  = '</ul></nav>';
        $config['first_tag_open']  = '<li class="notNum-common first-page">';
        $config['first_link']      = '最新文章';
        $config['first_tag_close'] = '</li>';
        $config['prev_link']       = '前一頁';
        $config['prev_tag_open']   = '<li class="notNum-common prev-page">';
        $config['prev_tag_close']  = '</li>';
        $config['next_link']       = '下一頁';
        $config['next_tag_open']   = '<li class="notNum-common next-page">';
        $config['next_tag_close']  = '</li>';
        $config['cur_tag_open']    = '<li class="num-page active"><a href="#">';
        $config['cur_tag_close']   = '</a></li>';
        $config['num_tag_open']    = '<li class="num-page">';
        $config['num_tag_close']   = '</li>';
        $config['last_tag_open']   = '<li class="notNum-common last-page">';
        $config['last_link']       = '最舊文章';
        $config['last_tag_close']  = '</li>';

        $this->pagination->initialize($config);
        $page    = $config['per_page'];
        $segment = $this->uri->segment($segment);
        // http://n.sfs.tw/content/index/10846

        return array(
            "page"    => $page,
            "segment" => $segment,
        );
    }
}
