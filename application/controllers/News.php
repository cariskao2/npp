<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH . '/libraries/BaseController.php';

class News extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        // $this->load->library('session');
        $this->load->model('news_model');
        $this->isLoggedIn();
        $this->global['pageTitle'] = '時代力量後台管理';
    }

    /**
     * Page not found : error 404
     */
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

    // 新聞訊息的各項列表
    public function lists($type_id)
    {
        if ($type_id < 1 || $type_id > 3) {
            redirect('news/lists/1');
        }

        // 參考 segment_helper.php
        // echo '<script>alert("' . uri_segment() . '")</script>';

        switch ($type_id) {
            case '1':
                $this->global['navTitle'] = '新聞訊息 - 法案及議事說明 - 列表';
                break;
            case '2':
                $this->global['navTitle'] = '新聞訊息 - 懶人包及議題追追追 - 列表';
                break;
            case '3':
                $this->global['navTitle'] = '新聞訊息 - 行動紀實 - 列表';
                break;
        }

        $this->session->unset_userdata('myRedirect');

        $searchText         = $this->security->xss_clean($this->input->post('searchText'));
        $data['searchText'] = $searchText;

        $count = $this->news_model->listingCount($searchText, $type_id); //算出總筆數
        // echo ' count: ' . $count;

        $returns = $this->paginationCompress("news/lists/" . $type_id . '/', $count, 10, 4); //記得加上「/」
        // echo ' segment-News: ' . $returns['segment'];

        $data['listItems']     = $this->news_model->listing($searchText, $type_id, $returns["page"], $returns["segment"]);
        $data['getTagsChoice'] = $this->news_model->getTagsChoice();
        $data['type_id']       = $type_id; //用來帶入newsLists_f中searchText的form action 跟 add

        $this->global['navActive'] = base_url('news/lists/' . $type_id . '/');

        $myRedirect = str_replace('/npp/', '', $_SERVER['REQUEST_URI']);
        $this->session->set_userdata('myRedirect', $myRedirect);

        $this->loadViews("newsLists", $this->global, $data, null);
    }

    // 標籤
    public function tagLists()
    {
        $this->session->unset_userdata('myRedirect');
        $this->global['navTitle'] = '新聞訊息 - 標籤列表';

        $searchText         = $this->security->xss_clean($this->input->post('searchText'));
        $data['searchText'] = $searchText;

        $count = $this->news_model->tagsListingCount($searchText); //算出總筆數

        $returns = $this->paginationCompress("news/tagLists/", $count, 10, 3);

        $data['newsTags'] = $this->news_model->tagsListing($searchText, $returns["page"], $returns["segment"]);
        // $this->global['pageTitle'] = '標籤管理';
        $this->global['navActive'] = base_url('news/tagLists/');

        $myRedirect = str_replace('/npp/', '', $_SERVER['REQUEST_URI']);
        $this->session->set_userdata('myRedirect', $myRedirect);

        $this->loadViews("tagLists", $this->global, $data, null);
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

    public function newsEdit($pr_id)
    {
        $editProtectChcek = $this->news_model->editProtectCheck($pr_id);

        if ($editProtectChcek == 0) {
            redirect('news/lists/1');
        }

        // $data['roles'] = $this->news_model->getUserRoles();
        $data = array(
            'userInfo'      => $this->news_model->getPressReleaseInfo($pr_id),
            'getTagsChoice' => $this->news_model->getTagsChoice($pr_id),
            'getTagsList'   => $this->news_model->getTagsList(),
            // 'error' => '',
        );

        // Cannot use object of type stdClass as array 解決方案
        foreach ($data['userInfo'] as $key => $value) {
            if ($key == 'pr_type_id') {
                $type_id = $value;
            }
        }

        $this->global['navActive'] = base_url('news/lists/' . $type_id . '/');

        // $this->global['pageTitle'] = '編輯最新新聞資料';
        switch ($type_id) {
            case '1':
                $this->global['navTitle'] = '新聞訊息 - 法案及議事說明 - 編輯';
                break;
            case '2':
                $this->global['navTitle'] = '新聞訊息 - 懶人包及議題追追追 - 編輯';
                break;
            case '3':
                $this->global['navTitle'] = '新聞訊息 - 行動紀實 - 編輯';
                break;
        }

        $getTagsId = [];
        foreach ($data['getTagsChoice'] as $key => $value) {
            // Cannot use object of type stdClass as array 解決方案
            array_push($getTagsId, $value->tags_id);
        }

        $data['getTagsID'] = $getTagsId;

        $this->loadViews("newsEdit", $this->global, $data, null);
    }

    public function editSend($pr_id)
    {
        $type_id = $this->security->xss_clean($this->input->post('type_id'));

        $this->form_validation->set_rules('m_title', '大標', 'trim|required|max_length[128]|callback_mainTitleCheck[' . $type_id . ',2,' . $pr_id . ']');
        $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');
        $this->form_validation->set_rules('file', '圖片', 'callback_imgNameCheck[' . $type_id . ',2]');
        $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('check', '驗證失敗');
            $this->newsEdit($pr_id);
        } else {
            $m_title         = $this->security->xss_clean($this->input->post('m_title'));
            $s_title         = $this->security->xss_clean($this->input->post('s_title'));
            $date_start      = $this->security->xss_clean($this->input->post('date_start'));
            $time_start      = $this->security->xss_clean($this->input->post('time_start'));
            $editor          = $this->input->post('editor1');
            $tags            = $this->security->xss_clean($this->input->post('tags'));
            $showStatusCheck = $this->security->xss_clean($this->input->post('happy'));
            $oldImg          = $this->security->xss_clean($this->input->post('img_name'));

            // File upload configuration
            // $uploadPath = dirname(dirname(__DIR__)) . '/assets/uploads/news_upload/' . $type_id . '/';
            $uploadPath              = 'assets/uploads/news_upload/' . $type_id . '/';
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

            $press_release_info = array(
                'main_title' => $m_title,
                'sub_title'  => $s_title,
                'date_start' => $date_start,
                'time_start' => $time_start,
                'editor'     => $editor,
            );

            if ($showStatusCheck != null || $showStatusCheck != '' || !empty($showStatusCheck)) {
                $showStatus                   = $showStatusCheck == 'Y' ? 1 : 0;
                $press_release_info['showup'] = $showStatus;
            }

            // 當新圖片成功上傳時就刪除舊的圖片
            if (!empty($uploadData)) {
                unlink(dirname(dirname(__DIR__)) . '/assets/uploads/news_upload/' . $type_id . '/' . $oldImg);
                // https://blog.longwin.com.tw/2009/01/php-get-directory-file-path-dirname-2008/
                // https://www.awaimai.com/408.html
                /*
                echo ' 2 層dirname: ' . dirname(dirname(__FILE__)) . '<br>';
                echo ' 1 層dirname: ' . dirname(__FILE__) . '<br>';
                echo ' FILE: ' . __FILE__ . '<br>';
                echo ' DIR: ' . __DIR__ . '<br>';
                echo ' 1 層dirname + DIR: ' . dirname(__DIR__);*/

                // 再把欄位的資料寫入資料庫
                $press_release_info['img'] = $uploadData;
            }

            $result = $this->news_model->pressReleaseUpdate($press_release_info, $pr_id);

            // 當回傳press_release update成功並return true而且tags不爲空,就check pr_tags資料表是否已有此pr_id
            if ($result) {
                $pr_tags_check = $this->news_model->editProtectCheck($pr_id, false, true);

                // 若此prid已存在,就先刪除此prid在tags資料表中的資料
                if ($pr_tags_check > 0) {
                    $this->news_model->prTagsDel($pr_id);
                }

                // 若$tags爲空就不在pr_tags寫入任何資料,否則就寫入$tags中的值
                if (!empty($tags)) {
                    $pr_tags_info = array();
                    $one_array    = array();

                    foreach ($tags as $key => $value) {
                        $one_array['pr_id']   = $pr_id;
                        $one_array['tags_id'] = $value;

                        $pr_tags_info[] = $one_array;
                    }

                    $this->news_model->prTagsAdd($pr_tags_info);
                }

                // CodeIgniter支援「快閃資料」(Flashdata), 其為一session資料, 並只對下一次的Server請求有效, 之後就自動清除。
                $array = array(
                    'success' => '儲存成功!',
                    // 'check'   => '驗證成功!',
                );

                $this->session->set_flashdata($array);
            } else {
                $this->session->set_flashdata('error', '儲存失敗!');
            }

            $myRedirect = $this->session->userdata('myRedirect');
            redirect($myRedirect);
            // $this->newsEdit($pr_id);
        }
    }

    /*
    ######## ########  #### ########         ########    ###     ######    ######
    ##       ##     ##  ##     ##               ##      ## ##   ##    ##  ##    ##
    ##       ##     ##  ##     ##               ##     ##   ##  ##        ##
    ######   ##     ##  ##     ##    #######    ##    ##     ## ##   ####  ######
    ##       ##     ##  ##     ##               ##    ######### ##    ##        ##
    ##       ##     ##  ##     ##               ##    ##     ## ##    ##  ##    ##
    ######## ########  ####    ##               ##    ##     ##  ######    ######
     */

    public function tagsEdit($tags_id)
    {
        // $this->global['pageTitle'] = '編輯標籤';
        $editProtectChcek = $this->news_model->editProtectCheck($tags_id, true);

        if ($editProtectChcek == 0) {
            redirect('news/tagLists/');
        }

        $this->global['navTitle']  = '新聞訊息 - 編輯標籤';
        $this->global['navActive'] = base_url('news/tagLists/');

        $data['getTagsEditInfo'] = $this->news_model->getTagsEditInfo($tags_id);

        $this->loadViews("tagsEdit", $this->global, $data, null);
    }

    public function tagsEditSend()
    {
        $id = $this->input->post('tagsid');

        $this->form_validation->set_rules('title', '名稱', 'trim|required|max_length[128]|callback_tags_check[' . $id . ']');
        $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('check', '驗證失敗');
            $this->tagsEdit($id);
        } else {
            $name            = $this->security->xss_clean($this->input->post('title'));
            $showStatusCheck = $this->input->post('happy');

            $userInfo = array(
                'name' => $name,
            );

            if ($showStatusCheck != null || $showStatusCheck != '' || !empty($showStatusCheck)) {
                $showStatus         = $showStatusCheck == 'Y' ? 1 : 0;
                $userInfo['showup'] = $showStatus;
            }

            $result = $this->news_model->tagsEditSend($userInfo, $id);

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
            // redirect('news/tagLists/');
        }
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

    // 新聞訊息各項目的新增頁面
    public function adds($type_id)
    {
        if ($type_id < 1 || $type_id > 3) {
            redirect('news/lists/1');
        }

        $this->global['navActive'] = base_url('news/lists/' . $type_id . '/');

        $data = array(
            'getTagsList' => $this->news_model->getTagsList(),
            'type_id'     => $type_id,
        );

        // $this->global['pageTitle'] = '新增最新新聞資料';
        switch ($type_id) {
            case '1':
                $this->global['navTitle'] = '新聞訊息 - 法案及議事說明 - 新增';
                break;
            case '2':
                $this->global['navTitle'] = '新聞訊息 - 懶人包及議題追追追 - 新增';
                break;
            case '3':
                $this->global['navTitle'] = '新聞訊息 - 行動紀實 - 新增';
                break;
        }

        $this->loadViews("newsAdds", $this->global, $data, null);
    }

    // 新聞訊息各項目的新增送出面
    public function addsSend($type_id)
    {
        $this->form_validation->set_rules('m_title', '大標', 'trim|required|max_length[128]|callback_mainTitleCheck[' . $type_id . ',1,""]');
        $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');
        $this->form_validation->set_rules('file', '圖片', 'callback_imgNameCheck[' . $type_id . ',1]');
        $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('check', '驗證失敗');
            $this->adds($type_id);
        } else {
            $m_title         = $this->security->xss_clean($this->input->post('m_title'));
            $s_title         = $this->security->xss_clean($this->input->post('s_title'));
            $date_start      = $this->security->xss_clean($this->input->post('date_start'));
            $editor          = $this->input->post('editor1');
            $tags            = $this->security->xss_clean($this->input->post('tags'));
            $showStatusCheck = $this->input->post('happy');
            $showStatus      = $showStatusCheck != 'N' ? 1 : 0;

            // File upload configuration
            // $uploadPath = dirname(dirname(__DIR__)) . '/assets/uploads/news_upload/' . $type_id . '/';
            $uploadPath              = 'assets/uploads/news_upload/' . $type_id . '/';
            $config['upload_path']   = $uploadPath;
            $config['allowed_types'] = 'jpg|jpeg|png|gif|svg';
            // $config['max_size'] = 1024;

            // Load and initialize upload library
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            // Upload file to server
            if ($this->upload->do_upload('file')) {
                // Uploaded file data
                $uploadData   = $this->upload->data();
                $uploadedFile = $uploadData['file_name'];

                // Insert files data into the database
                $press_release_info = array(
                    'pr_type_id' => $type_id,
                    'showup'     => $showStatus,
                    'img'        => $uploadedFile,
                    'main_title' => $m_title,
                    'sub_title'  => $s_title,
                    'date_start' => $date_start,
                    'editor'     => $editor,
                );

                $return_insert_id = $this->news_model->pressReleaseAdd($press_release_info);

                // 當回傳press_release成功insert的id(pr_id)時且有選擇標籤時,就將此標籤的資料insert到DB
                if ($return_insert_id > 0 && !empty($tags)) {
                    $pr_tags_info = array();
                    $one_array    = array();

                    foreach ($tags as $key => $value) {
                        $one_array['pr_id']   = $return_insert_id;
                        $one_array['tags_id'] = $value;

                        $pr_tags_info[] = $one_array;
                    }

                    $this->news_model->prTagsAdd($pr_tags_info);
                }

                // CodeIgniter支援「快閃資料」(Flashdata), 其為一session資料, 並只對下一次的Server請求有效, 之後就自動清除。
                $array = array(
                    'success' => '新增成功!',
                    // 'check'   => '驗證成功!',
                );

                $this->session->set_flashdata($array);
            } else {
                // upload debug ,loads the view display.php with error
                $error = array('error' => $this->upload->display_errors());
                $this->load->view('upload_debug_form', $error);
            }

            redirect('news/lists/' . $type_id . '/');
        }
    }

    // 標籤
    public function tagsAdd()
    {
        // $this->global['pageTitle'] = '新增標籤';
        $this->global['navTitle']  = '新聞訊息 - 新增標籤';
        $this->global['navActive'] = base_url('news/tagLists/');

        $this->loadViews("tagsAdd", $this->global, null);
    }

    public function tagsAddSend()
    {
        $this->form_validation->set_rules('title', '名稱', 'trim|required|max_length[128]|callback_tags_check');
        $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('check', '驗證失敗');
            $this->tagsAdd();
        } else {
            $name            = $this->security->xss_clean($this->input->post('title'));
            $showStatusCheck = $this->input->post('happy');

            $showStatus = $showStatusCheck != 'N' ? 1 : 0;

            $userInfo = array(
                'name'   => $name,
                'showup' => $showStatus,
            );

            $result = $this->news_model->tagsAddSend($userInfo);

            if ($result > 0) {
                // CodeIgniter支援「快閃資料」(Flashdata), 其為一session資料, 並只對下一次的Server請求有效, 之後就自動清除。
                $array = array(
                    'success' => '新增成功!',
                    // 'check'   => '驗證成功!',
                );

                $this->session->set_flashdata($array);
            } else {
                $this->session->set_flashdata('error', '新增失敗!');
            }

            redirect('news/tagLists/');
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

    public function imgNameCheck($str, $param)
    {
        $param = preg_split('/,/', $param);
        $type  = $param[0]; // 1.最新新聞 2.訊息公告 3.活動記錄
        $mode  = $param[1]; // 1.add 2.edit
        // $pr_id = $param[2]; // edit所需pr_id
        // echo $str . '<br>' . $type . '<br>' . $mode . '<br>' . $pr_id;
        $imgName = $_FILES['file']['name']; //圖片好像不能直接用$str來做

        // 若爲新增功能又沒有選擇圖片或圖片名稱爲空就報錯後離開
        if ($mode == 1) {
            if (!isset($imgName) || $imgName == '') {
                $this->form_validation->set_message('imgNameCheck', '請選擇要上傳的圖片');
                $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');
                return false;
            }
        }

        // 如果圖片檔名有空白字元就報錯後離開
        // \s: 任何空白字元(空白,換行,tab)。\S: 任何非空白字元(空白,換行,tab)。
        $pattern = "/\s/";
        if (preg_match($pattern, $imgName)) {
            // echo 'match';
            $this->form_validation->set_message('imgNameCheck', '圖片名稱不可有空白字元');
            $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');
            return false;
        }

        $nameRepeat = $this->news_model->imgNameCheck($imgName, $type);

        if ($nameRepeat > 0) {
            $this->form_validation->set_message('imgNameCheck', '已有同名的圖片名稱：「' . $imgName . '」!');
            $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');
            return false;
        } else {

            // 若爲編輯並且沒有選圖片就爲false離開,否則就檢查圖片格式
            if (!($mode == 2 && $imgName == '')) {

                $allowed_mime_type_arr = array('image/gif', 'image/jpeg', 'image/png', 'image/x-png', 'image/svg+xml');
                $mime                  = get_mime_by_extension($imgName);

                // 若圖片名稱沒有重複就檢查圖片格式是否正確。
                // in_array() 函数搜索数组中是否存在指定的值。
                if (in_array($mime, $allowed_mime_type_arr)) {
                    return true;
                } else {
                    $this->form_validation->set_message('imgNameCheck', '圖片格式不正確!<br>請選擇gif/jpg/jpeg/png/svg');
                    $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');
                    return false;
                }
            }
        }
    }

    public function mainTitleCheck($str, $param)
    {
        $param = preg_split('/,/', $param);
        $type  = $param[0]; // 1.最新新聞 2.訊息公告 3.活動記錄
        $mode  = $param[1]; // 1.add 2.edit
        $pr_id = $param[2]; // edit所需pr_id
        // echo $str . '<br>' . $type . '<br>' . $mode . '<br>' . $pr_id;

        $nameRepeat = $this->news_model->mainTitleCheck($str, $type, $mode, $pr_id);

        if ($nameRepeat > 0) {
            $this->form_validation->set_message('mainTitleCheck', '已有相同標題名稱：「' . $str . '」!');
            $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');
            return false;
        } else {
            return true;
        }
    }

    public function tags_check($str, $id = '')
    {
        $name       = $this->security->xss_clean($this->input->post('title'));
        $nameRepeat = $this->news_model->tagsCheck($name, $id);

        if ($nameRepeat > 0) {
            $this->form_validation->set_message('tags_check', '已有同名的標籤名稱：「' . $str . '」!');
            $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');
            return false;
        } else {
            return true;
        }
    }

    /*
    ########  ######## ##       ######## ######## ########
    ##     ## ##       ##       ##          ##    ##
    ##     ## ##       ##       ##          ##    ##
    ##     ## ######   ##       ######      ##    ######
    ##     ## ##       ##       ##          ##    ##
    ##     ## ##       ##       ##          ##    ##
    ########  ######## ######## ########    ##    ########
     */

    public function newsListDel()
    {
        //這裏的post('pr_id')是common.js的jQuery.ajax.data
        $pr_id   = $this->security->xss_clean($this->input->post('pr_id'));
        $type_id = $this->security->xss_clean($this->input->post('type_id'));
        $img     = $this->security->xss_clean($this->input->post('img'));

        unlink(dirname(dirname(__DIR__)) . '/assets/uploads/news_upload/' . $type_id . '/' . $img);

        // $userInfo = array('isDeleted' => 1, 'updatedBy' => $this->vendorId, 'updatedDtm' => date('Y-m-d H:i:s'));
        $result = $this->news_model->newsListDel($pr_id); //刪除資料庫數據

        // if ($result > 0) {
        if ($result) {
            echo (json_encode(array('status' => true)));
        } else {
            echo (json_encode(array('status' => false)));
        }
    }

    // 刪除標籤列表
    public function deleteNewsTag()
    {
        $id     = $this->input->post('tags_id');
        $result = $this->news_model->deleteNewsTag($id);

        if ($result > 0) {
            echo (json_encode(array('status' => true)));
        } else {
            echo (json_encode(array('status' => false)));
        }
    }
}
