<!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Add Employees</title>
            <link rel="stylesheet" href="./css/style.css">
        </head>
        <body class="add-employee-page">
            <header>
                <img src="img/Logo-Icon-Transparent.png" alt="Logo Icon" class="header-image"> <!-- The Logo was taken from a website that makes AI generated Logos. Link: https://www.vistaprint.ca/?PCXTVATINCLUSIVE=&couponCode=NEW20&utm_id=2B02324577947783127380&coupon=&partner=google&ps_vtp=7549902|5767695162||kwd-104664860|c|9212517||g&ps_vtp2=g|vistaprint|e|545692893331|||||&gad_source=1&gclid=Cj0KCQiAhvK8BhDfARIsABsPy4hKv6VPmNahynPMkZ4qq417cy9CjgPM22NQ5O_uqfrF-hJNm_9fLaQaAoEpEALw_wcB -->
                <h1>Add Employees</h1>
            </header>

            <main>
                <form action="add_employee.php" method="POST">
                    <!--Job Positions In a Company |   LINK FROM https://www.keka.com/glossary/job-title-->
                    <label for="name">Employee Name:</label>
                    <input type="text" id="name" name="name" required>
                    
                    <!-- Positions -->
                    <label for="position">Position:</label>
                    <select id="position" name="position" required>  
                        <option value="" disabled selected              >Select a Position</option>   
                        <option value="CEO"                             >Chief Executive Officer (CEO)</option>
                        <option value="CFO"                             >Chief Financial Officer (CFO)</option>
                        <option value="CMO"                             >Chief Marketing Officer (CMO)</option>
                        <option value="COO"                             >Chief Operating Officer (COO)</option>
                        <option value="HR"                              >Human Resources (HR)</option>
                        <option value="Sales_Manager"                   >Sales Manager</option>
                        <option value="Marketing_Specialist"            >Marketing Specialist</option>
                        <option value="Financial_Analyst"               >Financial Analyst</option>
                        <option value="Operations_Cordinator"           >Operations Coordinator</option>
                        <option value="Accountant"                      >Accountant</option>
                        <option value="Administrative_Assistant"        >Administrative Assistant</option>
                        <option value="Customer_Service_Representative" >Customer Service Representative</option>
                        <option value="IT_Support"                      >IT Support Specialist</option>
                    </select>

                    <!--Salary -->
                    <label for="salary">Salary: </label>
                    <input type="number" id="salary" name="salary"  required>
                    
                    <!-- Start_Date -->
                    <label for="start_date">Start Date: </label>
                    <input type="date" id="start_date" name="start_date" required>

                    <!-- Address -->
                    <label for="address">Address:</label>
                    <input type="text" id="address" name="address" required>

                    <!-- Phone Number -->
                    <label for="phone_number">Phone Number:</label>
                    <input type="tel" id="phone_number" name="phone_number" required>

                    <!-- Email -->
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>

                    <button type="submit" name="Submit">Add Employee</button>
                </form>

                <?php
                    require_once('crud.php');
                    require_once('validate.php'); 

                    //Create class objects
                    $crud  = new crud();
                    $valid = new validate();


                    if (isset($_POST['Submit'])) {
                        //
                        $name = $crud->escape_string($_POST['name']);
                        $position = $crud->escape_string($_POST['position']);
                        $salary = $crud->escape_string($_POST['hourly_pay']);
                        $start_date = $crud->escape_string($_POST['start_date']);
                        $address = $crud->escape_string($_POST['address']);
                        $phone_number = $crud->escape_string($_POST['phone_number']);
                        $email = $crud->escape_string($_POST['email']);

                        // Validate input data
                        $msg = $valid->checkEmpty($_POST, ['name', 'position', 'hourly_pay', 'start_date', 'address', 'phone_number', 'email']);
                        $checkSalary = $valid->validSalary($salary);
                        $checkPhone = $valid->validPhoneNumber($phone_number);
                        $checkEmail = $valid->validEmail($email);


                        if($msg != null){
                            echo "<p>$msg</p>";
                            echo "<a href='javascript:self.history.back();'>Go Back</a>";
                        } else if (!$checkSalary) {
                            echo "<p>Please Enter a Positive Number</p>";
                            echo "<a href='javascript:self.history.back();'>Go Back</a>";
                        } else if (!$checkPhone) {
                            echo "<p>Please Enter A Valid Phone Number</p>";
                            echo "<a href='javascript:self.history.back();'>Go Back</a>";
                        } else if (!$checkEmail) {
                            echo "<p>Please Enter a valid Email</p>";
                            echo "<a href='javascript:self.history.back();'>Go Back</a>";
                        } else {
                            // Insert data into the database
                            $query = "INSERT INTO employees (name, position, salary, start_date, address, phone_number, email) VALUES ('$name', '$position', '$salary', '$start_date', '$address', '$phone_number', '$email')";

                            if ($crud->execute($query)) {
                                // Let user know employee was added successfully
                                echo "<p>New Employee Added Successfully!</p>";
                            } else {
                                // Let user know there was an error adding the employee
                                echo "<p>Error Adding Employee</p>";
                            }
                        }
                    }
                ?>

            </main>

            <footer>
                <small> Employee Portal Assignment | Teegan Buttigieg | Lakehead #1263104</small>
            </footer>
        </body>
</html>