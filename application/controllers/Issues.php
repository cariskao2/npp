<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH . '/libraries/BaseController.php';

class Issues extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        // $this->load->library('ftp');
        // $this->load->library('session');
        $this->load->model('issues_model');
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

    // 議題列表
    public function issuesAllList()
    {
        $this->session->unset_userdata('myRedirect');

        $this->global['navTitle']  = '重點法案 - 議題列表管理 - 列表';
        $this->global['navActive'] = base_url('issues/issuesAllList/');

        $searchText         = $this->security->xss_clean($this->input->post('searchText'));
        $data['searchText'] = $searchText;

        $count = $this->issues_model->issuesAllListingCount($searchText);

        $returns = $this->paginationCompress('issues/issuesAllList/', $count, 10, 3);

        $data['issuesAllList'] = $this->issues_model->issuesAllListing($searchText, $returns["page"], $returns["segment"]);

        // 進入列表就先將網址儲存起來,到時候編輯的完成後就可導航回原本的列表頁面
        $myRedirect = str_replace('/npp/', '', $_SERVER['REQUEST_URI']);
        $this->session->set_userdata('myRedirect', $myRedirect);

        $this->loadViews('issuesAllList', $this->global, $data, null);
    }

    // 議題類別
    public function issuesClassList()
    {
        $this->session->unset_userdata('myRedirect');

        $this->global['navTitle']  = '重點法案 - 議題類別管理 - 列表';
        $this->global['navActive'] = base_url('issues/issuesClassList/');

        $searchText         = $this->security->xss_clean($this->input->post('searchText'));
        $data['searchText'] = $searchText;

        $count = $this->issues_model->issuesClassListingCount($searchText);

        $returns = $this->paginationCompress('issues/issuesClassList/', $count, 10, 3);

        $data['issuesClassList'] = $this->issues_model->issuesClassListing(false, $searchText, $returns["page"], $returns["segment"]);

        $myRedirect = str_replace('/npp/', '', $_SERVER['REQUEST_URI']);
        $this->session->set_userdata('myRedirect', $myRedirect);

        $this->loadViews('issuesClassList', $this->global, $data, null);
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
    public function issuesAllAdd()
    {
        $this->global['navTitle']  = '重點法案 - 議題列表管理 - 新增';
        $this->global['navActive'] = base_url('issues/issuesAllList/');

        $data = array(
            'getIssuesClassList' => $this->issues_model->issuesClassListing(true),
        );

        $this->loadViews('issuesAllAdd', $this->global, $data, null);
    }

    public function issuesAllAddSend()
    {
        $this->form_validation->set_rules('file', '圖片', 'callback_imgAll_check');
        $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');
        $this->form_validation->set_rules('title', '標題', 'trim|required|max_length[128]|callback_issuesAll_check');
        $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');
        $this->form_validation->set_rules('ic', '類別', 'required|max_length[128]|callback_issuesSelect_check');
        $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('check', '驗證失敗');
            $this->issuesAllAdd();
        } else {
            $title           = $this->security->xss_clean($this->input->post('title'));
            $ic              = $this->security->xss_clean($this->input->post('ic'));
            $introduction    = $this->security->xss_clean($this->input->post('introduction'));
            $e               = $this->input->post('editor1');
            $showStatusCheck = $this->input->post('happy');

            $showStatus = $showStatusCheck != 'N' ? 1 : 0;

            // File upload configuration
            // $uploadPath = dirname(dirname(__DIR__)) . '/assets/uploads/issuesAll_uplaod/';
            $uploadPath              = 'assets/uploads/issuesAll_uplaod/';
            $config['upload_path']   = $uploadPath;
            $config['allowed_types'] = 'jpg|jpeg|png|gif|svg';
            // $config['max_size'] = 1024;

            // Load and initialize upload library
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            // Upload file to server
            if ($this->upload->do_upload('file')) {
                $fileData   = $this->upload->data();
                $uploadData = $fileData['file_name'];
            } else {
                // upload debug ,loads the view display.php with error
                $error = array('error' => $this->upload->display_errors());
                $this->load->view('upload_debug_form', $error);
            }

            $userInfo = array(
                'ic_id'        => $ic,
                'showup'       => $showStatus,
                'img'          => $uploadData,
                'title'        => $title,
                'introduction' => $introduction,
                'editor'       => $e,
            );

            $insert_id = $this->issues_model->issuesAllAddSend($userInfo);

            if ($insert_id > 0) {
                $this->session->set_flashdata('success', '新增成功!');
            } else {
                $this->session->set_flashdata('error', '新增失敗!');
            }

            redirect('issues/issuesAllList/');
        }
    }

    // 議題類別
    public function issuesClassAdd()
    {
        $this->global['navTitle']  = '重點法案 - 議題類別管理 - 新增';
        $this->global['navActive'] = base_url('issues/issuesClassList/');

        $this->loadViews("issuesClassAdd", $this->global, null);
    }

    public function issuesClassAddSend()
    {
        $this->form_validation->set_rules('name', '名稱', 'trim|required|max_length[128]|callback_issuesClass_check');
        $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');
        $this->form_validation->set_rules('file', '圖片', 'callback_img_check');
        $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('check', '驗證失敗');
            $this->issuesClassAdd();
        } else {
            $name            = $this->security->xss_clean($this->input->post('name'));
            $showStatusCheck = $this->input->post('happy');

            $showStatus = $showStatusCheck != 'N' ? 1 : 0;

            // File upload configuration
            // $uploadPath = dirname(dirname(__DIR__)) . '/assets/uploads/members_upload/';
            $uploadPath              = 'assets/uploads/issuesClass_uplaod/';
            $config['upload_path']   = $uploadPath;
            $config['allowed_types'] = 'jpg|jpeg|png|gif|svg';
            // $config['max_size'] = 1024;

            // Load and initialize upload library
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            // Upload file to server
            if ($this->upload->do_upload('file')) {
                $fileData   = $this->upload->data();
                $uploadData = $fileData['file_name'];
            } else {
                // upload debug ,loads the view display.php with error
                $error = array('error' => $this->upload->display_errors());
                $this->load->view('upload_debug_form', $error);
            }

            $userInfo = array(
                'name'   => $name,
                'showup' => $showStatus,
                'img'    => $uploadData,
            );

            $result = $this->issues_model->issuesClassAddSend($userInfo);

            if ($result > 0) {
                $this->session->set_flashdata('success', '新增成功!');
            } else {
                $this->session->set_flashdata('error', '新增失敗!');
            }

            redirect('issues/issuesClassList/');
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

    // 議題列表
    public function issuesAllEdit($id)
    {
        $editProtectChcek = $this->issues_model->editProtectCheck($id, 'issues-all');

        if ($editProtectChcek == 0) {
            redirect('issues/issuesAllList/');
        }

        $this->global['navTitle']  = '重點法案 - 議題類別管理 - 編輯';
        $this->global['navActive'] = base_url('issues/issuesAllList/');

        $data = array(
            'getIssuesAllInfo'   => $this->issues_model->getIssuesAllInfo($id),
            'getIssuesClassList' => $this->issues_model->issuesClassListing(true),
        );

        $this->loadViews("issuesAllEdit", $this->global, $data, null);
    }

    public function issuesAllEditSend($id)
    {
        $this->form_validation->set_rules('file', '圖片', 'callback_imgAll_check[' . $id . ']');
        $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');
        $this->form_validation->set_rules('title', '標題', 'trim|required|max_length[128]|callback_issuesAll_check[' . $id . ']');
        $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');
        $this->form_validation->set_rules('ic', '類別', 'required|max_length[128]|callback_issuesSelect_check');
        $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('check', '驗證失敗');
            $this->issuesAllEdit($id);
        } else {
            $title           = $this->security->xss_clean($this->input->post('title'));
            $ic              = $this->security->xss_clean($this->input->post('ic'));
            $introduction    = $this->security->xss_clean($this->input->post('introduction'));
            $e               = $this->input->post('editor1');
            $showStatusCheck = $this->input->post('happy');
            $oldImg          = $this->security->xss_clean($this->input->post('img_name'));

            // File upload configuration
            // $uploadPath = dirname(dirname(__DIR__)) . '/assets/uploads/members_upload/';
            $uploadPath              = 'assets/uploads/issuesAll_uplaod/';
            $config['upload_path']   = $uploadPath;
            $config['allowed_types'] = 'jpg|jpeg|png|gif|svg';
            // $config['max_size'] = 1024;

            // Load and initialize upload library
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            // Upload file to server
            if ($this->upload->do_upload('file')) {
                $fileData   = $this->upload->data();
                $uploadData = $fileData['file_name'];
            } else {
                // upload debug ,loads the view display.php with error
                $error = array('error' => $this->upload->display_errors());
                $this->load->view('upload_debug_form', $error);
            }

            $userInfo = array(
                'ic_id'        => $ic,
                'title'        => $title,
                'introduction' => $introduction,
                'editor'       => $e,
            );

            if ($showStatusCheck != null || $showStatusCheck != '' || !empty($showStatusCheck)) {
                $showStatus         = $showStatusCheck == 'Y' ? 1 : 0;
                $userInfo['showup'] = $showStatus;
            }

            // 當新圖片成功上傳時就刪除舊的圖片
            if (!empty($uploadData)) {
                unlink(dirname(dirname(__DIR__)) . '/assets/uploads/issuesAll_uplaod/' . $oldImg);

                $userInfo['img'] = $uploadData;
            }

            $result = $this->issues_model->issuesAllEditSend($userInfo, $id);

            if ($result > 0) {
                $this->session->set_flashdata('success', '新增成功!');
            } else {
                $this->session->set_flashdata('error', '新增失敗!');
            }

            $myRedirect = $this->session->userdata('myRedirect');
            redirect($myRedirect);
        }
    }

    //  議題類別
    public function issuesClassEdit($id)
    {
        $editProtectChcek = $this->issues_model->editProtectCheck($id, 'issues-class');

        if ($editProtectChcek == 0) {
            redirect('issues/issuesClassList/');
        }

        $this->global['navTitle']  = '重點法案 - 議題類別管理 - 編輯';
        $this->global['navActive'] = base_url('issues/issuesClassList/');

        $data['getIssuesClassInfo'] = $this->issues_model->getIssuesClassInfo($id);

        $this->loadViews("issuesClassEdit", $this->global, $data, null);
    }

    public function issuesClassEditSend($id)
    {
        $this->form_validation->set_rules('file', '圖片', 'callback_img_check[' . $id . ']');
        $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');
        $this->form_validation->set_rules('name', '名稱', 'trim|required|max_length[128]|callback_issuesClass_check[' . $id . ']');
        $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('check', '驗證失敗');
            $this->issuesClassEdit($id);
        } else {
            $name            = $this->security->xss_clean($this->input->post('name'));
            $showStatusCheck = $this->input->post('happy');
            $oldImg          = $this->security->xss_clean($this->input->post('img_name'));

            // File upload configuration
            // $uploadPath = dirname(dirname(__DIR__)) . '/assets/uploads/members_upload/';
            $uploadPath              = 'assets/uploads/issuesClass_uplaod/';
            $config['upload_path']   = $uploadPath;
            $config['allowed_types'] = 'jpg|jpeg|png|gif|svg';
            // $config['max_size'] = 1024;

            // Load and initialize upload library
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            // Upload file to server
            if ($this->upload->do_upload('file')) {
                $fileData   = $this->upload->data();
                $uploadData = $fileData['file_name'];
            } else {
                // upload debug ,loads the view display.php with error
                $error = array('error' => $this->upload->display_errors());
                $this->load->view('upload_debug_form', $error);
            }

            $userInfo = array(
                'name' => $name,
            );

            if ($showStatusCheck != null || $showStatusCheck != '' || !empty($showStatusCheck)) {
                $showStatus         = $showStatusCheck == 'Y' ? 1 : 0;
                $userInfo['showup'] = $showStatus;
            }

            // 當新圖片成功上傳時就刪除舊的圖片
            if (!empty($uploadData)) {
                unlink(dirname(dirname(__DIR__)) . '/assets/uploads/issuesClass_uplaod/' . $oldImg);

                $userInfo['img'] = $uploadData;
            }

            $result = $this->issues_model->issuesClassEditSend($userInfo, $id);

            if ($result > 0) {
                // CodeIgniter支援「快閃資料」(Flashdata), 其為一session資料, 並只對下一次的Server請求有效, 之後就自動清除。
                $array = array(
                    'success' => '更新成功!',
                );

                $this->session->set_flashdata($array);
            } else {
                $this->session->set_flashdata('error', '更新失敗!');
            }

            $myRedirect = $this->session->userdata('myRedirect');
            redirect($myRedirect);
            // redirect('issues/issuesClassList/');
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

    public function deleteIssuesAll()
    {
        $id  = $this->security->xss_clean($this->input->post('id'));
        $img = $this->security->xss_clean($this->input->post('img'));

        unlink(dirname(dirname(__DIR__)) . '/assets/uploads/issuesAll_uplaod/' . $img);

        $result = $this->issues_model->deleteIssues($id, 'all');

        if ($result > 0) {
            echo (json_encode(array('status' => true)));
        } else {
            echo (json_encode(array('status' => false)));
        }
    }

    public function deleteIssuesClass()
    {
        $id  = $this->security->xss_clean($this->input->post('ic_id'));
        $img = $this->security->xss_clean($this->input->post('img'));

        unlink(dirname(dirname(__DIR__)) . '/assets/uploads/issuesClass_uplaod/' . $img);

        $result = $this->issues_model->deleteIssues($id, 'class');

        if ($result > 0) {
            echo (json_encode(array('status' => true)));
        } else {
            echo (json_encode(array('status' => false)));
        }
    }

/*
..............######..##.....##.########..######..##....##
.............##....##.##.....##.##.......##....##.##...##.
.............##.......##.....##.##.......##.......##..##..
.............##.......#########.######...##.......#####...
.............##.......##.....##.##.......##.......##..##..
.............##....##.##.....##.##.......##....##.##...##.
..............######..##.....##.########..######..##....##
 */

    // 議題列表大圖
    public function imgAll_check($str, $id = '')
    {
        $imgName = $_FILES['file']['name']; //圖片好像不能直接用$str來做

        // 若爲新增功能又沒有選擇圖片或圖片名稱爲空就報錯後離開
        if ($id == '') {
            if (!isset($imgName) || $imgName == '') {
                $this->form_validation->set_message('imgAll_check', '請選擇要上傳的圖片');
                $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');

                return false;
            }
        }

        // 如果圖片檔名有空白字元就報錯後離開
        // \s: 任何空白字元(空白,換行,tab)。\S: 任何非空白字元(空白,換行,tab)。
        $pattern = "/\s/";
        if (preg_match($pattern, $imgName)) {
            // echo 'match';
            $this->form_validation->set_message('imgAll_check', '圖片名稱不可有空白字元');
            $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');

            return false;
        }

        $nameRepeat = $this->issues_model->imgAll_check($imgName);

        if ($nameRepeat > 0) {
            $this->form_validation->set_message('imgAll_check', '已有同名的圖片名稱：「' . $imgName . '」!');
            $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');
            return false;
        } else {

            // 若爲編輯並且沒有選圖片就爲false離開,否則就檢查圖片格式
            if (!($id != '' && $imgName == '')) {

                $allowed_mime_type_arr = array('image/gif', 'image/jpeg', 'image/png', 'image/x-png', 'image/svg+xml');
                $mime                  = get_mime_by_extension($imgName);

                // 檢查圖片格式。
                // in_array() 函数搜索数组中是否存在指定的值。
                if (in_array($mime, $allowed_mime_type_arr)) {
                    return true;
                } else {
                    $this->form_validation->set_message('imgAll_check', '圖片格式不正確!<br>請選擇jpg|jpeg|png|gif|svg');
                    $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');

                    return false;
                }
            }
        }
    }

    // 議題類別封面圖
    public function img_check($str, $id = '')
    {
        $imgName = $_FILES['file']['name']; //圖片好像不能直接用$str來做

        // 若爲新增功能又沒有選擇圖片或圖片名稱爲空就報錯後離開
        if ($id == '') {
            if (!isset($imgName) || $imgName == '') {
                $this->form_validation->set_message('img_check', '請選擇要上傳的圖片');
                $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');

                return false;
            }
        }

        // 如果圖片檔名有空白字元就報錯後離開
        // \s: 任何空白字元(空白,換行,tab)。\S: 任何非空白字元(空白,換行,tab)。
        $pattern = "/\s/";
        if (preg_match($pattern, $imgName)) {
            // echo 'match';
            $this->form_validation->set_message('img_check', '圖片名稱不可有空白字元');
            $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');

            return false;
        }

        $nameRepeat = $this->issues_model->img_check($imgName);

        if ($nameRepeat > 0) {
            $this->form_validation->set_message('img_check', '已有同名的圖片名稱：「' . $imgName . '」!');
            $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');
            return false;
        } else {

            // 若爲編輯並且沒有選圖片就爲false離開,否則就檢查圖片格式
            if (!($id != '' && $imgName == '')) {

                $allowed_mime_type_arr = array('image/gif', 'image/jpeg', 'image/png', 'image/x-png', 'image/svg+xml');
                $mime                  = get_mime_by_extension($imgName);

                // 檢查圖片格式。
                // in_array() 函数搜索数组中是否存在指定的值。
                if (in_array($mime, $allowed_mime_type_arr)) {
                    return true;
                } else {
                    $this->form_validation->set_message('img_check', '圖片格式不正確!<br>請選擇jpg|jpeg|png|gif|svg');
                    $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');

                    return false;
                }
            }
        }
    }

    // 類別check是否沒有選擇
    public function issuesSelect_check($str)
    {
        $ic = $this->security->xss_clean($this->input->post('ic'));

        if ($ic == 0) {
            $this->form_validation->set_message('issuesSelect_check', '請選擇一個類別');
            $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');
            return false;
        } else {
            return true;
        }
    }

    public function issuesAll_check($str, $id = '')
    {
        $title      = $this->security->xss_clean($this->input->post('title'));
        $nameRepeat = $this->issues_model->issuesAll_check($title, $id);

        if ($nameRepeat > 0) {
            $this->form_validation->set_message('issuesAll_check', '已有同名的議題列表名稱：「' . $str . '」!');
            $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');
            return false;
        } else {
            return true;
        }
    }

    public function issuesClass_check($str, $id = '')
    {
        $name       = $this->security->xss_clean($this->input->post('name'));
        $nameRepeat = $this->issues_model->issuesClass_check($name, $id);

        if ($nameRepeat > 0) {
            $this->form_validation->set_message('issuesClass_check', '已有同名的議題類別名稱：「' . $str . '」!');
            $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');
            return false;
        } else {
            return true;
        }
    }

    /*
    ..######...#######..########..########
    .##....##.##.....##.##.....##....##...
    .##.......##.....##.##.....##....##...
    ..######..##.....##.########.....##...
    .......##.##.....##.##...##......##...
    .##....##.##.....##.##....##.....##...
    ..######...#######..##.....##....##...
     */
    public function issuesClassSort()
    {

        $this->global['navTitle']  = '重點法案 - 議題類別管理 - 排序';
        $this->global['navActive'] = base_url('issues/issuesClassList/');

        $data['issuesClassListing'] = $this->issues_model->sortList();

        $this->loadViews("issuesClassSort", $this->global, $data, null);
    }

    public function issuesClassSortSend()
    {
        $sort   = $this->security->xss_clean($this->input->post('newSort'));
        $result = $this->issues_model->sort($sort);

        if ($result > 0) {
            $this->session->set_flashdata('success', '排序已更新!');
        } else {
            $this->session->set_flashdata('error', '排序更新失敗!');
        }
        // 這裏要用排序插件的$.ajax({success})來做路徑導引導才能成功
    }
}
