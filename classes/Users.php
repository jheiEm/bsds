<?php
require_once('../config.php');

class Users extends DBConnection {
    private $settings;

    public function __construct(){
        global $_settings;
        $this->settings = $_settings;
        parent::__construct();
    }

    public function __destruct(){
        parent::__destruct();
    }

    public function save_users(){
        extract($_POST);
        $data = '';

        // Set location_id to null if user type is 1
        if(isset($_POST['type']) && $_POST['type'] == 1) {
            $_POST['location_id'] = null;
        }

         //Check if the username already exists
        $chk = $this->conn->query("SELECT * FROM `users` WHERE username ='{$username}' " . ($id > 0 ? " AND id != '{$id}' " : ""))->num_rows;
//        if($chk > 0){
//            //return json_encode(['status' => 3, 'message' => 'Username already exists.']);
//
//        }
        foreach($_POST as $k => $v){
            if(!in_array($k, array('id', 'password'))) {
                if(!empty($data)) $data .= ", ";
                $data .= " {$k} = '{$v}' ";
            }
        }



        if(!empty($password)){
            $password = md5($password);
            if(!empty($data)) $data .= ", ";
            $data .= " `password` = '{$password}' ";
        }

        if(empty($id)){
            // Insert new user
            $qry = $this->conn->query("INSERT INTO users SET {$data}");
            if($qry){
                $id = $this->conn->insert_id;
                $this->settings->set_flashdata('success', 'User Details successfully saved.');
                $resp['status'] = 1;
            } else {
                $resp['status'] = 2;
            }

        } else {
            // Update existing user
            $qry = $this->conn->query("UPDATE users SET $data WHERE id = {$id}");
            if($qry){
                $this->settings->set_flashdata('success', 'User Details successfully updated.');
                if($id == $this->settings->userdata('id')){
                    foreach($_POST as $k => $v){
                        if($k != 'id'){
                            if(!empty($data)) $data .= ", ";
                            $this->settings->set_userdata($k, $v);
                        }
                    }
                    if(isset($fname) && isset($move))
                        $this->settings->set_userdata('avatar', $fname);
                }
                $resp['status'] = 1;
            } else {
                $resp['status'] = 2;
            }
        }

        // Handle avatar upload
        if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){
            $fname = 'uploads/avatar-' . $id . '.png';
            $dir_path = base_app . $fname;
            $upload = $_FILES['img']['tmp_name'];
            $type = mime_content_type($upload);
            $allowed = array('image/png', 'image/jpeg');
            if(!in_array($type, $allowed)){
                $resp['msg'] .= " But Image failed to upload due to invalid file type.";
            } else {
                $new_height = 200;
                $new_width = 200;
                list($width, $height) = getimagesize($upload);
                $t_image = imagecreatetruecolor($new_width, $new_height);
                $gdImg = ($type == 'image/png') ? imagecreatefrompng($upload) : imagecreatefromjpeg($upload);
                imagecopyresampled($t_image, $gdImg, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                if($gdImg){
                    if(is_file($dir_path))
                        unlink($dir_path);
                    $uploaded_img = imagepng($t_image, $dir_path);
                    imagedestroy($gdImg);
                    imagedestroy($t_image);
                } else {
                    $resp['msg'] .= " But Image failed to upload due to unknown reason.";
                }
            }
            if(isset($uploaded_img)){
                $this->conn->query("UPDATE users SET `avatar` = CONCAT('{$fname}', '?v=', unix_timestamp(CURRENT_TIMESTAMP)) WHERE id = '{$id}' ");
            }
        }

        return json_encode($resp);
    }

    public function delete_users(){
        extract($_POST);
        $avatar = $this->conn->query("SELECT avatar FROM users WHERE id = '{$id}'")->fetch_array()['avatar'];
        $qry = $this->conn->query("DELETE FROM users WHERE id = $id");
        if($qry){
            $this->settings->set_flashdata('success', 'User Details successfully deleted.');
            if(is_file(base_app.$avatar))
                unlink(base_app.$avatar);
            $resp['status'] = 'success';
        } else {
            $resp['status'] = 'failed';
        }
        return json_encode($resp);
    }

    // New function to check username availability
    public function check_username(){
        extract($_POST);
        $chk = $this->conn->query("SELECT COUNT(*) FROM `users` WHERE username = '{$username}'")->fetch_row()[0];
        if($chk > 0) {
            return json_encode(['status' => 'error', 'message' => 'Username already exists.']);
        } else {
            return json_encode(['status' => 'success']);
        }
    }
}

$users = new Users();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
switch ($action) {
    case 'save':
        echo $users->save_users();
        break;
    case 'check_username':
        echo $users->check_username();
        break;
    case 'delete':
        echo $users->delete_users();
        break;
    default:
        // echo $sysset->index();
        break;
}
