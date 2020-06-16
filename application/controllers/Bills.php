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

//  議題列表
    public function billStatusAdd()
    {
        $this->global['navTitle']  = '重點法案 - 法案狀態管理 - 新增';
        $this->global['navActive'] = base_url('bills/billStatusList/');

        $data = array(
            // 'getIssuesClassList' => $this->issues_model->issuesClassListing(true),
        );

        $this->loadViews('billStatusAdd', $this->global, $data, null);
    }
}
