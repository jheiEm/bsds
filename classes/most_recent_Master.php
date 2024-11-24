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
    function delete_disbursement_schedule(){
        extract($_POST);
        $del = $this->conn->query("DELETE FROM `disbursement_schedule` where id = '{$id}'");
        if($del){
            $resp['status'] = 'success';
            $this->settings->set_flashdata('success',"Scholarship Grant successfully deleted.");
        }else{
            $resp['status'] = 'failed';
            $resp['error'] = $this->conn->error;
        }
        return json_encode($resp);

    }

    function save_disbursement_schedule(){
        extract($_POST);
        $data = "";
        foreach($_POST as $k =>$v){
            if(!in_array($k,array('id'))){
                if(!empty($data)) $data .=",";
                $data .= " `{$k}`='{$v}' ";
            }
        }
        $check = $this->conn->query("SELECT * FROM `disbursement_schedule` where `schedule_date` = '{$schedule_date}' ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
        if($this->capture_err())
            return $this->capture_err();
        if($check > 0){
            $resp['status'] = 'failed';
            $resp['msg'] = "Disbursement Schedule already exist.";
            return json_encode($resp);
            exit;
        }
        if(empty($id)){
            $sql = "INSERT INTO `disbursement_schedule` set {$data} ";
            $save = $this->conn->query($sql);
        }else{
            $sql = "UPDATE `disbursement_schedule` set {$data} where id = '{$id}' ";
            $save = $this->conn->query($sql);
        }
        if($save){
            $resp['status'] = 'success';
            if(empty($id))
                $this->settings->set_flashdata('success',"New Disbursement Schedule successfully saved.");
            else
                $this->settings->set_flashdata('success',"Disbursement Schedule successfully updated.");
        }else{
            $resp['status'] = 'failed';
            $resp['err'] = $this->conn->error."[{$sql}]";
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
            if(in_array($k,array('mother_fullname','father_fullname','firstname','lastname','middlename','contact','address','dob','age','gender','status','district_name'))){
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
    function save_historys(){
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
            if(!in_array($k,array('id','mother_fullname','father_fullname','firstname','lastname','middlename','contact','address','dob','age','gender','status','indiRadio','scheme_id'))){
                $v = $this->conn->real_escape_string($v);
                if(!empty($data)) $data .=",";
                $data .= " `{$k}`='{$v}' ";
            }
        }
        if(empty($id)){
            $sql = "INSERT INTO `scholar_history_list` set {$data} ";
        }else{
            $sql = "UPDATE `scholar_history_list` set {$data} where id = '{$id}' ";
// Build the update SQL for individual_list with dynamic fields
            $sql2 = "UPDATE `individual_list` SET {$data} WHERE id = ?";

// Prepare the statement
            if ($stmt2 = $this->conn->prepare($sql2)) {
                // Bind the id to the statement (assuming $id is an integer)
                $stmt2->bind_param("i", $id);  // "i" indicates that $id is an integer

                // Execute the statement
                if ($stmt2->execute()) {
                    // If successful, you can handle success logic here
                    echo "Record in individual_list updated successfully!";
                } else {
                    // Handle failure
                    echo "Error updating record in individual_list: " . $stmt2->error;
                }

                // Close the statement
                $stmt2->close();
            } else {
                // If preparing the statement fails
                echo "Error preparing statement: " . $this->conn->error;
            }
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
    function save_history(){
        $_POST['user_id'] = $this->settings->userdata('id');
        extract($_POST);

        // Handle new individual creation if necessary
        if (empty($individual_id)) {
            $new_individual = $this->save_new_individual();
            if ($new_individual && !is_array($new_individual)) {
                $individual_id = $this->conn->insert_id;
                $_POST['individual_id'] = $individual_id;
            } else {
                exit;  // Exit if new individual creation failed
            }
        }

        // Prepare the dynamic fields for both queries
        $data = [];
        foreach ($_POST as $k => $v) {
            if (!in_array($k, ['id', 'mother_fullname', 'father_fullname', 'firstname', 'lastname', 'middlename', 'contact', 'address', 'dob', 'age', 'gender', 'status', 'indiRadio', 'scheme_id'])) {
                $data[$k] = $this->conn->real_escape_string($v);  // Escape special characters
            }
        }

        // Prepare the SQL for scholar_history_list
        $columns = implode(", ", array_map(function($key) { return "`$key` = ?"; }, array_keys($data)));
        $values = array_values($data);
        $sql = empty($id)
            ? "INSERT INTO `scholar_history_list` SET $columns"
            : "UPDATE `scholar_history_list` SET $columns WHERE id = ?";

        // Prepare and execute the scholar_history_list query
        if ($stmt = $this->conn->prepare($sql)) {
            if (!empty($id)) {
                $values[] = $id;  // Add the ID for update
            }
            $stmt->bind_param(str_repeat('s', count($values)), ...$values);  // Bind all values as strings (adjust type if necessary)
            if ($stmt->execute()) {
                // Proceed with further logic after successful update
                $resp['status'] = 'success';
                $this->settings->set_flashdata(empty($id) ? 'success' : 'success', empty($id) ? "New Disbursement Record successfully saved." : "Disbursement Record successfully updated.");
            } else {
                $resp['status'] = 'failed';
                $resp['err'] = "Error updating scholar_history_list: " . $stmt->error;
                return json_encode($resp);
            }
            $stmt->close();
        } else {
            $resp['status'] = 'failed';
            $resp['err'] = "Error preparing scholar_history_list query: " . $this->conn->error;
            return json_encode($resp);
        }

        // Prepare and execute the update for individual_list if necessary
        if (!empty($scheme_id)) {
            $sql2 = "UPDATE `individual_list` SET scheme_id = ? WHERE id = ?";
            if ($stmt2 = $this->conn->prepare($sql2)) {
                $stmt2->bind_param("ii", $scheme_id, $individual_id);  // Assuming both are integers
                if ($stmt2->execute()) {
                    // Record in individual_list updated successfully
                    echo "Scheme updated successfully in individual_list!";
                } else {
                    // Handle failure in individual_list update
                    echo "Error updating individual_list: " . $stmt2->error;
                }
                $stmt2->close();
            } else {
                echo "Error preparing individual_list query: " . $this->conn->error;
            }
        }

        // Return response
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
    function save_individuals(){
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
    function save_individual(){
        extract($_POST);
        $data = "";

        // Step 1: Retrieve the scheme_name from scheme_list based on scheme_id in individual_list
        $scheme_query = $this->conn->query("SELECT s.name 
                                        FROM `individual_list` i
                                        JOIN `scheme_list` s ON s.id = i.scheme_id
                                        WHERE i.id = '{$id}' LIMIT 1");

        if ($scheme_query->num_rows > 0) {
            $scheme_row = $scheme_query->fetch_assoc();
            $scheme_name = $scheme_row['name'];  // Retrieve the scheme name
        } else {
            $resp['status'] = 'failed';
            $resp['msg'] = 'Invalid individual or scheme not found.';
            return json_encode($resp);
        }

        // Step 2: Define the deduction amounts for each scheme
        $scheme_deductions = [
            'BPEAP - 3K' => 3000,
            'BPEAP - 4K' => 4000,
            'BPEAP - 5K' => 5000,
            'SCHEME 1 - 25K' => 25000,
            'SCHEME 2 - 10K' => 10000,
        ];

        // Step 3: Check if scheme exists in the deduction array
        if (!array_key_exists($scheme_name, $scheme_deductions)) {
            $resp['status'] = 'failed';
            $resp['msg'] = 'Scheme not recognized for deduction.';
            return json_encode($resp);
        }

        // Step 4: Calculate the deduction amount based on the scheme
        $deduction_amount = $scheme_deductions[$scheme_name];

        // Prepare the individual data to be saved
        foreach ($_POST as $k => $v) {
            if (!in_array($k, ['id'])) {
                $v = $this->conn->real_escape_string($v);
                if (!empty($data)) $data .= ", ";
                $data .= " `{$k}` = '{$v}' ";
            }
        }

        // Step 5: Update the individual_list table with the new data
        $sql = "UPDATE `individual_list` SET {$data} WHERE id = '{$id}'";
        $save = $this->conn->query($sql);

        // Check if the individual data is successfully saved
        if ($save) {
            $resp['status'] = 'success';
            $this->settings->set_flashdata('success', "Individual's Details Successfully updated.");

            // Step 6: Proceed with budget deduction if status is 1 (Disbursement Completed)
            if ($status == 1) {
                // Fetch the oldest budget record with status 1 (disbursement completed)
                $budget_query = $this->conn->query("SELECT * FROM `budget` WHERE `status` = 1 ORDER BY `date_created` ASC LIMIT 1");

                if ($budget_query->num_rows > 0) {
                    $budget = $budget_query->fetch_assoc();


                    // Step 7: Check if there is enough remaining amount to deduct
                    if ($budget['amount'] >= $deduction_amount) {
                        // Step 8: Calculate the new remaining amount and issued amount
                        $new_remaining_amount = $budget['amount'] - $budget['issued_amount'] - $deduction_amount;

                        $new_issued_amount = $budget['issued_amount'] + $deduction_amount;

                        // Step 9: Update the budget table with the new remaining and issued amounts
                        $this->conn->query("UPDATE `budget` SET `remaining_amount` = '{$new_remaining_amount}', `issued_amount` = '{$new_issued_amount}' WHERE `id` = '{$budget['id']}'");

                        // Optionally, update the status of the budget to fully disbursed if remaining amount is 0
                        if ($new_remaining_amount <= 0) {
                            $this->conn->query("UPDATE `budget` SET `status` = 2 WHERE `id` = '{$budget['id']}'");  // Fully Disbursed
                        }
                        // Log the disbursement in the history table
                        /*                        $transaction_id = 'TX' . time();  // Generate a unique transaction ID (you can change this logic)
                                                $location_id = 1;  // Example: Location ID (this can be dynamic, passed from a form or another table)

                                                $disbursement_history_sql = "INSERT INTO `disbursement_history`
                                                (transaction_id, scheme_id, individual_id, location_id, disbursed_amount, disbursed_date, disbursed_by, date)
                                                VALUES
                                                ('{$transaction_id}', '{$scheme_id}', '{$id}', '{$location_id}', '{$disbursed_amount}', NOW(), '{$_SESSION['user_id']}', NOW())";

                                                $this->conn->query($disbursement_history_sql);*/

                        // Return success response
                        $resp['status'] = 'success';
                        $resp['msg'] = 'Individual and budget updated successfully, budget deducted.';
                    } else {
                        // Not enough budget available
                        $resp['status'] = 'failed';
                        $resp['msg'] = 'Insufficient budget to deduct the specified amount.';
                    }
                } else {
                    // No budget found with status 1
                    $resp['status'] = 'failed';
                    $resp['msg'] = 'No valid budget found to deduct from.';
                }
            }
        } else {
            $resp['status'] = 'failed';
            $resp['msg'] = 'An error occurred while updating the individual data. Error: ' . $this->conn->error;
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
    case 'save_disbursement_schedule':
        echo $Master->save_disbursement_schedule();
        break;
    case 'delete_disbursement_schedule':
        echo $Master->delete_disbursement_schedule();
        break;

    default:
        // echo $sysset->index();
        break;
}