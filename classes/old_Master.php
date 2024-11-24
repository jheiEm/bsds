<?php
require_once('../config.php');
Class Master extends DBConnection {
    private $settings;
    public function __construct(){
        global $_settings;
        $this->settings = $_settings;
        parent::__construct();
    }
    public function __destruct(){
        parent::__destruct();
    }
    function capture_err(){
        if(!$this->conn->error)
            return false;
        else{
            $resp['status'] = 'failed';
            $resp['error'] = $this->conn->error;
            return json_encode($resp);
            exit;
        }
    }
    function save_scheme(){
        extract($_POST);
        $data = "";
        foreach($_POST as $k =>$v){
            if(!in_array($k,array('id'))){
                if(!empty($data)) $data .=",";
                $data .= " `{$k}`='{$v}' ";
            }
        }
        $check = $this->conn->query("SELECT * FROM `scheme_list` where `name` = '{$name}' ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
        if($this->capture_err())
            return $this->capture_err();
        if($check > 0){
            $resp['status'] = 'failed';
            $resp['msg'] = "Scholarship Grant Name already exist.";
            return json_encode($resp);
            exit;
        }
        if(empty($id)){
            $sql = "INSERT INTO `scheme_list` set {$data} ";
            $save = $this->conn->query($sql);
        }else{
            $sql = "UPDATE `scheme_list` set {$data} where id = '{$id}' ";
            $save = $this->conn->query($sql);
        }
        if($save){
            $resp['status'] = 'success';
            if(empty($id))
                $this->settings->set_flashdata('success',"New Scholarship Grant successfully saved.");
            else
                $this->settings->set_flashdata('success',"Scholarship Grant successfully updated.");
        }else{
            $resp['status'] = 'failed';
            $resp['err'] = $this->conn->error."[{$sql}]";
        }
        return json_encode($resp);
    }
    function delete_scheme(){
        extract($_POST);
        $del = $this->conn->query("DELETE FROM `scheme_list` where id = '{$id}'");
        if($del){
            $resp['status'] = 'success';
            $this->settings->set_flashdata('success',"Scholarship Grant successfully deleted.");
        }else{
            $resp['status'] = 'failed';
            $resp['error'] = $this->conn->error;
        }
        return json_encode($resp);

    }
    function save_location(){
        extract($_POST);
        $data = "";
        foreach($_POST as $k =>$v){
            if(!in_array($k,array('id'))){
                $v = $this->conn->real_escape_string($v);
                if(!empty($data)) $data .=",";
                $data .= " `{$k}`='{$v}' ";
            }
        }
        $check = $this->conn->query("SELECT * FROM `scholar_location_list` where `location` = '{$location}' ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
        if($this->capture_err())
            return $this->capture_err();
        if($check > 0){
            $resp['status'] = 'failed';
            $resp['msg'] = "Disbursement Location Name already exist.";
            return json_encode($resp);
            exit;
        }
        if(empty($id)){
            $sql = "INSERT INTO `scholar_location_list` set {$data} ";
            $save = $this->conn->query($sql);
        }else{
            $sql = "UPDATE `scholar_location_list` set {$data} where id = '{$id}' ";
            $save = $this->conn->query($sql);
        }
        if($save){
            $resp['status'] = 'success';
            if(empty($id))
                $this->settings->set_flashdata('success',"New Disbursement Location successfully saved.");
            else
                $this->settings->set_flashdata('success',"Disbursement Location successfully updated.");
        }else{
            $resp['status'] = 'failed';
            $resp['err'] = $this->conn->error."[{$sql}]";
        }
        return json_encode($resp);
    }
    function delete_location(){
        extract($_POST);
        $del = $this->conn->query("DELETE FROM `scholar_location_list` where id = '{$id}'");
        if($del){
            $resp['status'] = 'success';
            $this->settings->set_flashdata('success',"Disbursement Location successfully deleted.");
        }else{
            $resp['status'] = 'failed';
            $resp['error'] = $this->conn->error;
        }
        return json_encode($resp);

    }
    function save_new_individual(){
        $data = "";
        foreach($_POST as $k =>$v){
            if(in_array($k,array('mother_fullname','father_fullname','firstname','lastname','middlename','contact','address','dob','age','gender','status','vaccination_name'))){
                $v= $this->conn->real_escape_string($v);
                if(!empty($data)) $data .=", ";
                $data .=" `{$k}` = '{$v}' ";
            }
        }
        $code = '';
        while(true){
            $code = mt_rand(1,999999999999999);
            $code = sprintf("%'.015d",$code);
            $check = $this->conn->query("SELECT * FROM `individual_list` where tracking_code = '{$code}' ")->num_rows;
            if($check <= 0)
                break;
        }
        $data .=", `tracking_code` = '{$code}' ";
        $sql = "INSERT INTO `individual_list` set {$data}";
        $save = $this->conn->query($sql);
        if($save){
            return 1;
        }else{
            $resp['status'] = 'failed';
            $resp['msg'] = 'An error occurred. Error: '.$this->conn->error;
        }
        return json_encode($resp);
    }
    function save_history(){
        $_POST['user_id'] = $this->settings->userdata('id');
        extract($_POST);
        if(empty($individual_id)){
            $new_individual =$this->save_new_individual();
            if($new_individual && !is_array($new_individual)){
                $individual_id= $this->conn->insert_id;
                $_POST['individual_id'] =$individual_id;
            }else{
                exit;
            }
        }
        $data = "";
        foreach($_POST as $k =>$v){
            if(!in_array($k,array('id','mother_fullname','father_fullname','firstname','lastname','middlename','contact','address','dob','age','gender','status','indiRadio'))){
                $v = $this->conn->real_escape_string($v);
                if(!empty($data)) $data .=",";
                $data .= " `{$k}`='{$v}' ";
            }
        }
        if(empty($id)){
            $sql = "INSERT INTO `scholar_history_list` set {$data} ";
        }else{
            $sql = "UPDATE `scholar_history_list` set {$data} where id = '{$id}' ";
        }
        $save = $this->conn->query($sql);
        if($save){
            $resp['status'] = 'success';
            if(empty($id)){
                $this->settings->set_flashdata('success',"New Disbursement Record successfully saved.");
                $id = $this->conn->insert_id;
            }else{
                $this->settings->set_flashdata('success',"Disbursement Record successfully updated.");
            }
            $resp['id'] = $id;
            if(isset($status)){
                $this->conn->query("UPDATE `individual_list` set status = '{$status}' where id = '{$individual_id}'");
            }
        }else{
            $resp['status'] = 'failed';
            $resp['err'] = $this->conn->error."[{$sql}]";
        }
        return json_encode($resp);
    }
    function delete_history(){
        extract($_POST);
        $del = $this->conn->query("DELETE FROM `scholar_history_list` where id = '{$id}'");
        if($del){
            $resp['status'] = 'success';
            $this->settings->set_flashdata('success',"Disbursement Record successfully deleted.");
        }else{
            $resp['status'] = 'failed';
            $resp['error'] = $this->conn->error;
        }
        return json_encode($resp);

    }
    function get_individual(){
        extract($_POST);
        $individual_qry = $this->conn->query("SELECT *,concat(lastname,', ', firstname, ' ', middlename ) as name FROM individual_list where tracking_code ='{$code}'");
        $data=array();
        if($individual_qry->num_rows > 0){
            foreach($individual_qry->fetch_array() as $k => $v){
                if($k =='dob'){
                    $v = date("M d, Y",strtotime($v));
                }
                if(!is_numeric($k))
                    $data[$k] = $v;
            }
        }
        return json_encode($data);
    }
    function save_individual(){
        extract($_POST);
        $data = "";
        foreach($_POST as $k =>$v){
            if(!in_array($k,array('id'))){
                $v= $this->conn->real_escape_string($v);
                if(!empty($data)) $data .=", ";
                $data .=" `{$k}` = '{$v}' ";
            }
        }
        $sql = "UPDATE `individual_list` set {$data} where id = '{$id}'";
        $save = $this->conn->query($sql);
        if($save){
            $resp['status'] = 'success';
            $this->settings->set_flashdata('success'," Individual's Details Successfully updated.");
        }else{
            $resp['status'] = 'failed';
            $resp['msg'] = 'An error occurred. Error: '.$this->conn->error;
        }
        return json_encode($resp);
    }
    function delete_individual(){
        extract($_POST);
        $del = $this->conn->query("DELETE FROM `individual_list` where id = '{$id}'");
        if($del){
            $resp['status'] = 'success';
            $this->settings->set_flashdata('success',"Individual successfully deleted.");
        }else{
            $resp['status'] = 'failed';
            $resp['error'] = $this->conn->error;
        }
        return json_encode($resp);

    }

    function save_student(){
        extract($_POST);
        $data = "";
        foreach($_POST as $k =>$v){
            if(!in_array($k,array('id'))){
                if(!empty($data)) $data .=",";
                $data .= " `{$k}`='{$v}' ";
            }
        }
        $check = $this->conn->query("SELECT * FROM `student_list` where `firstname` = '{$firstname}' ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
        if($this->capture_err())
            return $this->capture_err();
        if($check > 0){
            $resp['status'] = 'failed';
            $resp['msg'] = "Student Name already exist.";
            return json_encode($resp);
            exit;
        }
        if(empty($id)){
            $sql = "INSERT INTO `student_list` set {$data} ";
            $save = $this->conn->query($sql);
        }else{
            $sql = "UPDATE `student_list` set {$data} where id = '{$id}' ";
            $save = $this->conn->query($sql);
        }
        if($save){
            $resp['status'] = 'success';
            if(empty($id))
                $this->settings->set_flashdata('success',"New Student successfully saved.");
            else
                $this->settings->set_flashdata('success',"Student successfully updated.");
        }else{
            $resp['status'] = 'failed';
            $resp['err'] = $this->conn->error."[{$sql}]";
        }
        return json_encode($resp);
    }

    function delete_patient(){
        extract($_POST);
        $del = $this->conn->query("DELETE FROM `student_list` where id = '{$id}'");
        if($del){
            $resp['status'] = 'success';
            $this->settings->set_flashdata('success',"Student Successfully Deleted.");
        }else{
            $resp['status'] = 'failed';
            $resp['error'] = $this->conn->error;
        }
        return json_encode($resp);

    }

    function save_budget(){
        extract($_POST);
        $data = "";
        foreach($_POST as $k =>$v){
            if(!in_array($k,array('id'))){
                $v = $this->conn->real_escape_string($v);
                if(!empty($data)) $data .=",";
                $data .= " `{$k}`='{$v}' ";
            }
        }
        $check = $this->conn->query("SELECT * FROM `budget` where `budget_name` = '{$budget_name}' ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
        if($this->capture_err())
            return $this->capture_err();
        if($check > 0){
            $resp['status'] = 'failed';
            $resp['msg'] = "Budget Allocation already exist.";
            return json_encode($resp);
            exit;
        }
        if(empty($id)){
            $sql = "INSERT INTO `budget` set {$data} ";
            $save = $this->conn->query($sql);
        }else{
            $sql = "UPDATE `budget` set {$data} where id = '{$id}' ";
            $save = $this->conn->query($sql);
        }
        if($save){
            $resp['status'] = 'success';
            if(empty($id))
                $this->settings->set_flashdata('success',"Budget successfully saved.");
            else
                $this->settings->set_flashdata('success',"Budget successfully updated.");
        }else{
            $resp['status'] = 'failed';
            $resp['err'] = $this->conn->error."[{$sql}]";
        }
        return json_encode($resp);
    }

    function delete_budget() {
        if (isset($_POST['id'])) {
            $id = intval($_POST['id']); // Ensure the ID is an integer
            error_log("Attempting to delete budget entry with ID: " . $id); // Log the ID

            // Prepare the DELETE statement
            $stmt = $this->conn->prepare("DELETE FROM `budget` WHERE id = ?");
            if ($stmt) {
                $stmt->bind_param("i", $id);
                $del = $stmt->execute();

                if ($del) {
                    $resp['status'] = 'success';
                    $this->settings->set_flashdata('success', "Budget successfully deleted.");
                    error_log("Successfully deleted budget entry with ID: " . $id); // Log success
                } else {
                    $resp['status'] = 'failed';
                    $resp['error'] = $this->conn->error;
                    error_log("Failed to delete budget entry with ID: " . $id . ". Error: " . $resp['error']); // Log error
                }
                $stmt->close();
            } else {
                $resp['status'] = 'failed';
                $resp['error'] = 'Prepare failed: ' . $this->conn->error;
                error_log("Prepare failed: " . $this->conn->error); // Log prepare failure
            }
        } else {
            $resp['status'] = 'failed';
            $resp['error'] = 'ID not set.';
            error_log("ID not set in POST request."); // Log missing ID
        }
        return json_encode($resp);
    }



}

$Master = new Master();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();
switch ($action) {
    case 'save_student':
        echo $Master->save_student();
        break;
    case 'save_scheme':
        echo $Master->save_scheme();
        break;
    case 'delete_scheme':
        echo $Master->delete_scheme();
        break;
    case 'save_location':
        echo $Master->save_location();
        break;
    case 'delete_patient':
        echo $Master->delete_patient();
        break;
    case 'delete_location':
        echo $Master->delete_location();
        break;
    case 'save_history':
        echo $Master->save_history();
        break;
    case 'delete_history':
        echo $Master->delete_history();
        break;
    case 'get_individual':
        echo $Master->get_individual();
        break;
    case 'save_individual':
        echo $Master->save_individual();
        break;
    case 'delete_individual':
        echo $Master->delete_individual();
        break;
    // case 'get_budget':
    // 	echo $Master->get_budget();
    // break;
    case 'save_budget':
        echo $Master->save_budget();
        break;
    case 'delete_budget':
        echo $Master->delete_budget();
        break;

    default:
        // echo $sysset->index();
        break;
}