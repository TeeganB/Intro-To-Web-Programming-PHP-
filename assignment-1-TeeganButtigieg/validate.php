<?php
class validate {
    // Check if specific fields are empty
    public function checkEmpty($data, $fields) {
        $msg = null;
        foreach ($fields as $value) {
            if (empty($data[$value])) {
                $msg .= "<p>$value field cannot be empty</p>";
            }
        }
        return $msg;
    }

    // Valid salary (positive numeric number)
    public function validSalary($salary) {
        if (!preg_match("/^[0-9]+$/", $salary) || $salary<=0){
            return "Salary must be a positive number.";
        }
        return true;
    }

    // Validate phone number (must be 10 digits)
    public function validPhoneNumber($phone_number) {
        if (!preg_match("/^[0-9]{10}$/", $phone_number)) {
            return "Phone number must be 10 digits long.";
        }
        return true;
    }

    // Validate email
    public function validEmail($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "Invalid email format.";
        }
        return true;
    }
}
?>