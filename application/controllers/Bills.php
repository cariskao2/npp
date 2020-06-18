<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH . '/libraries/BaseController.php';

class Bills extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        // $this->load->library('ftp');
        // $this->load->library('session');
        $this->load->model('bills_model');
        $this->isLoggedIn();
        $this->global['pageTitle'] = '時代力量後台管理';
    }

    public function pageNotFound()
    {
        $this->global['pageTitle'] = 'CodeInsect : 404 - Page Not Found';

        $this->loadViews("404", $this->global, null, null);
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

    // 法案狀態列表
    public function billStatusList()
    {
        $this->session->unset_userdata('myRedirect');

        $this->global['navTitle']  = '重點法案 - 法案狀態管理 - 列表';
        $this->global['navActive'] = base_url('bills/billStatusList/');

        $searchText         = $this->security->xss_clean($this->input->post('searchText'));
        $data['searchText'] = $searchText;

        $count = $this->bills_model->getBillStatusListCount($searchText);

        $returns = $this->paginationCompress('bills/billStatusList/', $count, 10, 3);

        $data['getBillStatusList'] = $this->bills_model->getBillStatusList($searchText, $returns["page"], $returns["segment"]);

        // 進入列表就先將網址儲存起來,到時候編輯的完成後就可導航回原本的列表頁面
        $myRedirect = str_replace('/npp/', '', $_SERVER['REQUEST_URI']);
        $this->session->set_userdata('myRedirect', $myRedirect);

        $this->loadViews('billStatusList', $this->global, $data, null);
    }

/*
....###....########..########.
...##.##...##.....##.##.....##
..##...##..##.....##.##.....##
.##.....##.##.....##.##.....##
.#########.##.....##.##.....##
.##.....##.##.....##.##.....##
.##.....##.########..########.
 */

    //  法案狀態新增
    public function billStatusAdd()
    {
        $this->global['navTitle']  = '重點法案 - 法案狀態管理 - 新增';
        $this->global['navActive'] = base_url('bills/billStatusList/');

        $data = array(
            // 'getIssuesClassList' => $this->issues_model->issuesClassListing(true),
        );

        $this->loadViews('billStatusAdd', $this->global, $data, null);
    }

    public function billStatusAddSend()
    {
        $this->form_validation->set_rules('name', '名稱', 'trim|required|max_length[128]|callback_billStatusNameCheck');
        $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('check', '驗證失敗');
            $this->billStatusAdd();
        } else {
            $name            = $this->security->xss_clean($this->input->post('name'));
            $color           = $this->security->xss_clean($this->input->post('color'));
            $showStatusCheck = $this->input->post('happy');
            $showStatus      = $showStatusCheck != 'N' ? 1 : 0;

            $userInfo = array(
                'name'  => $name,
                'shows' => $showStatus,
                'color' => $color,
            );

            $insert_id = $this->bills_model->billStatusAddSend($userInfo);

            if ($insert_id > 0) {
                $this->session->set_flashdata('success', '新增成功!');
            } else {
                $this->session->set_flashdata('error', '新增失敗!');
            }

            redirect('bills/billStatusList/');
        }
    }

/*
.########.########..####.########
.##.......##.....##..##.....##...
.##.......##.....##..##.....##...
.######...##.....##..##.....##...
.##.......##.....##..##.....##...
.##.......##.....##..##.....##...
.########.########..####....##...
 */

    // 法案狀態編輯
    public function billStatusEdit($id)
    {
        $editProtectChcek = $this->bills_model->editProtectCheck($id, 'bill-status');

        if ($editProtectChcek == 0) {
            redirect('bills/billStatusList/');
        }

        $this->global['navTitle']  = '重點法案 - 法案狀態管理 - 編輯';
        $this->global['navActive'] = base_url('bills/billStatusList/');

        $data = array(
            'getBillStatusInfo' => $this->bills_model->getBillStatusInfo($id),
        );

        $this->loadViews("billStatusEdit", $this->global, $data, null);
    }

    public function billStatusEditSend($id)
    {
        $this->form_validation->set_rules('name', '名稱', 'trim|required|max_length[128]|callback_billStatusNameCheck[' . $id . ']');
        $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('check', '驗證失敗');
            $this->billStatusEdit($id);
        } else {
            $name            = $this->security->xss_clean($this->input->post('name'));
            $color           = $this->security->xss_clean($this->input->post('color'));
            $showStatusCheck = $this->input->post('happy');

            $userInfo = array(
                'name'  => $name,
                'color' => $color,
            );

            if ($showStatusCheck != null || $showStatusCheck != '' || !empty($showStatusCheck)) {
                $showStatus        = $showStatusCheck == 'Y' ? 1 : 0;
                $userInfo['shows'] = $showStatus;
            }

            $result = $this->bills_model->billStatusEditSend($userInfo, $id);

            if ($result) {
                $this->session->set_flashdata('success', '新增成功!');
            } else {
                $this->session->set_flashdata('error', '新增失敗!');
            }

            $myRedirect = $this->session->userdata('myRedirect');
            redirect($myRedirect);
        }
    }

/*
.########..########.##.......########.########.########
.##.....##.##.......##.......##..........##....##......
.##.....##.##.......##.......##..........##....##......
.##.....##.######...##.......######......##....######..
.##.....##.##.......##.......##..........##....##......
.##.....##.##.......##.......##..........##....##......
.########..########.########.########....##....########
 */

    public function deleteBills()
    {
        $id     = $this->security->xss_clean($this->input->post('id'));
        $result = $this->bills_model->deleteBills($id, 'bill-status');

        if ($result > 0) {
            echo (json_encode(array('status' => true)));
        } else {
            echo (json_encode(array('status' => false)));
        }
    }

    /*
    ..######..##.....##.########..######..##....##
    .##....##.##.....##.##.......##....##.##...##.
    .##.......##.....##.##.......##.......##..##..
    .##.......#########.######...##.......#####...
    .##.......##.....##.##.......##.......##..##..
    .##....##.##.....##.##.......##....##.##...##.
    ..######..##.....##.########..######..##....##
     */

    public function billStatusNameCheck($str, $id = '')
    {
        $name       = $this->security->xss_clean($this->input->post('name'));
        $nameRepeat = $this->bills_model->billStatusNameCheck($name, $id);

        if ($nameRepeat > 0) {
            $this->form_validation->set_message('billStatusNameCheck', '已有同名的法案狀態名稱：「' . $str . '」!');
            $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');
            return false;
        } else {
            return true;
        }
    }
}
