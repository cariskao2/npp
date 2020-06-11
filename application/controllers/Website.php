<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH . '/libraries/BaseController.php';

class Website extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        // $this->load->library('session');
        $this->load->model('website_model');
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

    // 輪播列表
    public function carouselLists()
    {
        // 參考 segment_helper.php
        // echo '<script>alert("' . uri_segment() . '")</script>';
        $this->session->unset_userdata('myRedirect');

        $this->global['navTitle']  = '網站管理 - 輪播管理 - 列表';
        $this->global['navActive'] = base_url('website/carouselLists/');

        $searchText         = $this->security->xss_clean($this->input->post('searchText'));
        $data['searchText'] = $searchText;

        $count   = $this->website_model->carouselListCount($searchText); //算出總筆數
        $returns = $this->paginationCompress("website/carouselList/", $count, 10, 3);

        $data['getCarouselList'] = $this->website_model->carouselListing(false, $searchText, $returns["page"], $returns["segment"]);

        $myRedirect = str_replace('/npp/', '', $_SERVER['REQUEST_URI']);
        $this->session->set_userdata('myRedirect', $myRedirect);

        $this->loadViews("carouselLists", $this->global, $data, null);
    }

    /*
    ######## ########  #### ########
    ##       ##     ##  ##     ##
    ##       ##     ##  ##     ##
    ######   ##     ##  ##     ##
    ##       ##     ##  ##     ##
    ##       ##     ##  ##     ##
    ######## ########  ####    ##
     */

    // 陳情內容編輯
    public function petition()
    {
        $this->global['navTitle'] = '網站管理 - 陳情內容編輯';

        $data['getPetition'] = $this->website_model->getPetition();

        $this->loadViews("petition", $this->global, $data, null);
    }

    public function petitionSend()
    {
        $e = $this->input->post('editor1');

        $updateInfo = array(
            'editor' => $e,
        );

        $result = $this->website_model->petitionUpdate($updateInfo);

        if ($result) {
            $array = array(
                'success' => '更新成功!',
            );

            $this->session->set_flashdata($array);
        } else {
            $this->session->set_flashdata('error', '更新失敗!');
        }

        $this->petition();
        // redirect('website/setup');
    }

    // 其它設定
    public function setup($check = false)
    {
        // $this->global['pageTitle'] = '編輯標籤';
        $this->global['navTitle'] = '網站管理 - 其它設定';
        $data['getSetupInfo']     = $this->website_model->getSetupInfo();
        $this->loadViews("website_setup", $this->global, $data, null);
    }

    public function setupSend()
    {
        $this->form_validation->set_rules('mail', 'Email', 'trim|valid_email|max_length[128]');
        $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('check', '驗證失敗');
            $this->setup();
        } else {
            $mail        = $this->security->xss_clean($this->input->post('mail'));
            $fb          = $this->security->xss_clean($this->input->post('fb'));
            $address     = $this->security->xss_clean($this->input->post('address'));
            $num         = $this->security->xss_clean($this->input->post('num'));
            $fax         = $this->security->xss_clean($this->input->post('fax'));
            $servicetime = $this->security->xss_clean($this->input->post('servicetime'));

            $updateInfo = array(
                'mail'        => $mail,
                'fb'          => $fb,
                'address'     => $address,
                'num'         => $num,
                'fax'         => $fax,
                'servicetime' => $servicetime,
            );

            $result = $this->website_model->setupUpdate($updateInfo);

            if ($result) {
                // CodeIgniter支援「快閃資料」(Flashdata), 其為一session資料, 並只對下一次的Server請求有效, 之後就自動清除。
                $array = array(
                    'success' => '更新成功!',
                );

                $this->session->set_flashdata($array);
            } else {
                $this->session->set_flashdata('error', '更新失敗!');
            }

            $this->setup();
            // redirect('website/setup');
        }
    }

    // 輪播
    public function carouselEdit($id)
    {
        $editProtectChcek = $this->website_model->editProtectCheck($id);

        if ($editProtectChcek == 0) {
            redirect('website/carouselLists/');
        }

        $this->global['navTitle']  = '網站管理 - 輪播管理 - 編輯';
        $this->global['navActive'] = base_url('website/carouselLists/');

        $data['getCarouselInfo'] = $this->website_model->getCarouselInfo($id);

        $this->loadViews("carouselEdit", $this->global, $data, null);
    }

    public function carouselEditSend($id)
    {
        $this->form_validation->set_rules('title', '標題', 'trim|required|max_length[128]|callback_carouselTitleCheck[' . $id . ']');
        $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');
        $this->form_validation->set_rules('file', '圖片', 'callback_carouselImgCheck');
        $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('check', '驗證失敗');
            $this->carouselEdit($id);
        } else {
            $title           = $this->security->xss_clean($this->input->post('title'));
            $introduction    = $this->security->xss_clean($this->input->post('introduction'));
            $link            = $this->security->xss_clean($this->input->post('link'));
            $showStatusCheck = $this->input->post('happy');

            // File upload configuration
            // $uploadPath = dirname(dirname(__DIR__)) . '/assets/uploads/carousel_upload/';
            $uploadPath              = 'assets/uploads/carousel_upload/';
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

            $carousel_info = array(
                'title'        => $title,
                'introduction' => $introduction,
                'link'         => $link,
            );

            if ($showStatusCheck != null || $showStatusCheck != '' || !empty($showStatusCheck)) {
                $showStatus              = $showStatusCheck != 'N' ? 1 : 0;
                $carousel_info['showup'] = $showStatus;
            }

            // 當有選擇圖片時
            if (!empty($uploadData)) {
                // 就上傳新圖片並馬上刪除舊圖片
                $imgDelete  = $this->website_model->imgNameRepeatDel($id);
                $imgDelName = $imgDelete->img;
                unlink(dirname(dirname(__DIR__)) . '/assets/uploads/carousel_upload/' . $imgDelName);

                // 再把img欄位的資料存入info後再寫入資料庫
                $carousel_info['img'] = $uploadData;
            }

            $result = $this->website_model->carouselUpdate($carousel_info, $id);

            if ($result) {
                // CodeIgniter支援「快閃資料」(Flashdata), 其為一session資料, 並只對下一次的Server請求有效, 之後就自動清除。
                $array = array(
                    'success' => '更新成功!',
                );

                $this->session->set_flashdata($array);
            } else {
                $this->session->set_flashdata('error', '儲存失敗!');
            }

            $myRedirect = $this->session->userdata('myRedirect');
            redirect($myRedirect);
            // $this->carouselEdit($id);
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

    // 輪播
    public function carouselAdds()
    {
        $this->global['navTitle']  = '網站管理 - 輪播管理 - 新增';
        $this->global['navActive'] = base_url('website/carouselLists/');

        $this->loadViews("carouselAdds", $this->global, null);
    }

    public function carouselAddSend()
    {
        $this->form_validation->set_rules('title', '標題', 'trim|required|max_length[128]|callback_carouselTitleCheck');
        $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');
        $this->form_validation->set_rules('file', '圖片', 'callback_carouselImgCheck[true]');
        $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('check', '驗證失敗');
            $this->carouselAdds();
        } else {
            $title           = $this->security->xss_clean($this->input->post('title'));
            $introduction    = $this->security->xss_clean($this->input->post('introduction'));
            $link            = $this->security->xss_clean($this->input->post('link'));
            $showStatusCheck = $this->input->post('happy');
            $showStatus      = $showStatusCheck != 'N' ? 1 : 0;

            // File upload configuration
            // $uploadPath = dirname(dirname(__DIR__)) . '/assets/uploads/carousel_upload/';
            $uploadPath              = 'assets/uploads/carousel_upload/';
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

            $carousel_info = array(
                'img'          => $uploadData,
                'title'        => $title,
                'showup'       => $showStatus,
                'introduction' => $introduction,
                'link'         => $link,
            );

            $return_insert_id = $this->website_model->carouselAdd($carousel_info);

            if ($return_insert_id) {
                // CodeIgniter支援「快閃資料」(Flashdata), 其為一session資料, 並只對下一次的Server請求有效, 之後就自動清除。
                $array = array(
                    'success' => '新增成功!',
                );

                $this->session->set_flashdata($array);
            } else {
                $this->session->set_flashdata('error', '儲存失敗!');
            }

            // $this->carouselAdds();
            redirect('website/carouselLists/');
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

    // 輪播
    public function carouselTitleCheck($str, $id)
    {
        $title      = $this->security->xss_clean($this->input->post('title'));
        $nameRepeat = $this->website_model->carouselTitleCheck($id, $title);

        if ($nameRepeat > 0) {
            $this->form_validation->set_message('carouselTitleCheck', '已有同名的標題名稱：「' . $str . '」!');
            $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');
            return false;
        } else {
            return true;
        }
    }

    public function carouselImgCheck($str, $isAdd = false)
    {
        $imgName = $_FILES['file']['name'];

        if ($isAdd) {
            if (!isset($imgName) || $imgName == '') {
                $this->form_validation->set_message('carouselImgCheck', '請選擇要上傳的圖片');
                $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');
                return false;
            }
        }

        // 如果圖片檔名有空白字元就報錯後離開
        // \s: 任何空白字元(空白,換行,tab)。\S: 任何非空白字元(空白,換行,tab)。
        $pattern = "/\s/";
        if (preg_match($pattern, $imgName)) {
            // echo 'match';
            $this->form_validation->set_message('carouselImgCheck', '圖片名稱不可有空白字元');
            $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');
            return false;
        }

        $nameRepeat = $this->website_model->carouselImgCheck($imgName);

        if ($nameRepeat > 0) {
            $this->form_validation->set_message('carouselImgCheck', '已有同名的圖片名稱：「' . $imgName . '」!');
            $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');
            return false;
        } else {
            if ($imgName != '') {
                $allowed_mime_type_arr = array('image/gif', 'image/jpeg', 'image/png', 'image/x-png', 'image/svg+xml');
                $mime                  = get_mime_by_extension($imgName);

                // 若圖片名稱沒有重複就檢查圖片格式是否正確。
                // in_array() 函数搜索数组中是否存在指定的值。
                if (in_array($mime, $allowed_mime_type_arr)) {
                    return true;
                } else {
                    $this->form_validation->set_message('carouselImgCheck', '圖片格式不正確!<br>請選擇gif/jpg/jpeg/png/svg');
                    $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');
                    return false;
                }
            }
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

    // 輪播
    public function deleteCarousel()
    {
        //common.js的jQuery.ajax.data
        $id  = $this->input->post('id');
        $img = $this->input->post('img');

        unlink(dirname(dirname(__DIR__)) . '/assets/uploads/carousel_upload/' . $img);

        // $userInfo = array('isDeleted' => 1, 'updatedBy' => $this->vendorId, 'updatedDtm' => date('Y-m-d H:i:s'));
        $result = $this->website_model->deleteCarousel($id);

        if ($result > 0) {
            echo (json_encode(array('status' => true)));
        } else {
            echo (json_encode(array('status' => false)));
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
    public function carouselSorts()
    {
        $this->global['navTitle']  = '網站管理 - 輪播管理 - 排序';
        $this->global['navActive'] = base_url('website/carouselLists/');

        $data['getCarouselList'] = $this->website_model->carouselListing(true);

        $this->loadViews("carouselSorts", $this->global, $data, null);
    }

    public function carouselSortSend()
    {
        $sort   = $this->security->xss_clean($this->input->post('newSort'));
        $result = $this->website_model->sort($sort);

        if ($result > 0) {
            $this->session->set_flashdata('success', '排序已更新!');
        } else {
            $this->session->set_flashdata('error', '排序更新失敗!');
        }
        // $this->carouselSorts();// 這裏要用排序插件的$.ajax({success})來做路徑導引導才能成功
    }
}
