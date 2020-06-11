<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class : BaseController
 * Base Class to control over all the classes
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class BaseController extends CI_Controller
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
     * This function used to check the user is logged in or not
     */
    public function isLoggedIn()
    {
        $isLoggedIn = $this->session->userdata('isLoggedIn');

        if (!isset($isLoggedIn) || $isLoggedIn != true) {
            redirect('login');
        } else {
            $this->role      = $this->session->userdata('role');
            $this->vendorId  = $this->session->userdata('userId');
            $this->name      = $this->session->userdata('name');
            $this->roleText  = $this->session->userdata('roleText');
            $this->lastLogin = $this->session->userdata('lastLogin');

            $this->global['name']       = $this->name;
            $this->global['role']       = $this->role;
            $this->global['role_text']  = $this->roleText;
            $this->global['last_login'] = $this->lastLogin;
        }
    }

    /**
     * This function is used to check the access
     */
    public function isAdmin()
    {
        if ($this->role != ROLE_ADMIN) {
            return true;
        } else {
            return false;
        }
    }

    public function isManager()
    {
        if ($this->role != ROLE_MANAGER) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * This function is used to check the access
     */
    public function isTicketter()
    {
        if ($this->role != ROLE_ADMIN || $this->role != ROLE_MANAGER) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * This function is used to load the set of views
     */
    public function loadThis()
    {
        $this->global['pageTitle'] = '被拒絕進入';

        $this->load->view('includes/header', $this->global);
        $this->load->view('access');
        $this->load->view('includes/footer');
    }

    /**
     * This function is used to logged out user from system
     */
    public function logout()
    {
        $this->session->sess_destroy();

        redirect('login');
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

        $this->load->view('includes/header', $headerInfo);
        $this->load->view($viewName, $pageInfo);
        $this->load->view('includes/footer', $footerInfo);
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
        $this->load->library('pagination');

        $config['base_url']         = base_url() . $link;
        $config['total_rows']       = $count;
        $config['uri_segment']      = $segment; // 若使用page_query_string則無效
        $config['per_page']         = $perPage;
        $config['num_links']        = 5;
        $config['full_tag_open']    = '<nav><ul class="pagination">';
        $config['full_tag_close']   = '</ul></nav>';
        $config['first_tag_open']   = '<li class="arrow">';
        $config['first_link']       = '第一頁';
        $config['first_tag_close']  = '</li>';
        $config['prev_link']        = '上一頁';
        $config['prev_tag_open']    = '<li class="arrow">';
        $config['prev_tag_close']   = '</li>';
        $config['next_link']        = '下一頁';
        $config['next_tag_open']    = '<li class="arrow">';
        $config['next_tag_close']   = '</li>';
        $config['cur_tag_open']     = '<li class="active"><a href="#">';
        $config['cur_tag_close']    = '</a></li>';
        $config['num_tag_open']     = '<li>';
        $config['num_tag_close']    = '</li>';
        $config['last_tag_open']    = '<li class="arrow">';
        $config['last_link']        = '最後一頁';
        $config['last_tag_close']   = '</li>';
        $config['use_page_numbers'] = true; //true:使用頁碼方式。false:偏移量傳值
        // $config['page_query_string'] = true; // 將連結改成有?a=test&b=20的格式
        // $config['enable_query_strings'] = true; // 啟用，若要使用 'page_query_string'

        $this->pagination->initialize($config);
        $page    = $config['per_page'];
        $segment = !$config['use_page_numbers'] ? $this->uri->segment($segment) : ($this->uri->segment($segment) != null ? ($this->uri->segment($segment) - 1) * 10 : 0);
        // http://n.sfs.tw/content/index/10846

        return array(
            "page"    => $page,
            "segment" => $segment,
        );
    }
}
