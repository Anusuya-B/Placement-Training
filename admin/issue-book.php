<?php 
session_start();
include('includes/config.php');
error_reporting(0);
if(strlen($_SESSION['alogin'])==0) {   
    header('location:index.php');
} else {
    if(isset($_POST['submit'])) {
        $studentname=$_POST['studentname'];
        $batch=$_POST['batch'];
        $company=$_POST['company'];
        $roles=$_POST['roles'];
        $salary=$_POST['salary'];
        $locations=$_POST['locations'];
        $mobileno=$_POST['mobileno'];
        $emailid=$_POST['emailid'];
        $isissued=1;

        $sql_insert = "INSERT INTO tblselectedstudents (studentname, batch, companyname, roles, salary, locations, mobileno, bookid, emailid) 
        VALUES (:studentname, :batch, :company, :roles, :salary, :locations, :mobileno, :bookid, :emailid)";
        $insert_query = $dbh->prepare($sql_insert);
        $insert_query->bindParam(':studentname', $studentname, PDO::PARAM_STR);
        $insert_query->bindParam(':batch', $batch, PDO::PARAM_STR);
        $insert_query->bindParam(':company', $company, PDO::PARAM_STR);
        $insert_query->bindParam(':roles', $roles, PDO::PARAM_STR);
        $insert_query->bindParam(':salary', $salary, PDO::PARAM_STR);
        $insert_query->bindParam(':locations', $locations, PDO::PARAM_STR);
        $insert_query->bindParam(':mobileno', $mobileno, PDO::PARAM_STR);
        $insert_query->bindParam(':bookid',$bookid,PDO::PARAM_STR);
        $insert_query->bindParam(':emailid', $emailid, PDO::PARAM_STR);
        $insert_query->execute();

        // Assuming you have a book ID available for updating the book's status
        $book_id = $_POST['bookid']; // You need to have the book ID available

        $sql_update = "UPDATE tblselectedstudents SET isIssued = :isissued WHERE id = :bookid";
$update_query = $dbh->prepare($sql_update);
$update_query->bindParam(':isissued', $isissued, PDO::PARAM_INT);
$update_query->bindParam(':bookid', $book_id, PDO::PARAM_INT);

if($update_query->execute()) {
    $_SESSION['msg']="Book issued successfully";
    header('location:manage-issued-books.php');
} else {
    $_SESSION['error']="Something went wrong. Please try again";
    header('location:manage-issued-books.php');
}

    }
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Placement Management System</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
<script>
// function for get student name
function getstudent() {
$("#loaderIcon").show();
jQuery.ajax({
url: "get_student.php",
data:'studentid='+$("#studentid").val(),
type: "POST",
success:function(data){
$("#get_student_name").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}

//function for book details
function getbook() {
$("#loaderIcon").show();
jQuery.ajax({
url: "get_book.php",
data:'bookid='+$("#bookid").val(),
type: "POST",
success:function(data){
$("#get_book_name").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}

</script> 
<style type="text/css">
  .others{
    color:red;
}

</style>


</head>
<body>
      <!------MENU SECTION START-->
<?php include('includes/header.php');?>
<!-- MENU SECTION END-->
    <div class="content-wrapper">
         <div class="container">
        <div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">Add Selected Students
                
                            </div>

</div>
<div class="row">
<div class="col-md-10 col-sm-6 col-xs-12 col-md-offset-1">
<div class="panel panel-info">
<div class="panel-heading">
Issue a New Book
</div>
<div class="panel-body">
<form role="form" method="post">

<div class="form-group">
<label>Book ID</label>
<input class="form-control" type="text" name="bookid" required/>
</div>

<div class="form-group">
<label>Student Name</label>
<input class="form-control" type="text" name="studentname" autocomplete="off" required/>
</div>


<div class="form-group">
<label>Batch</label>
<input class="form-control" type="text" name="batch" required/>
</div>

 
<div class="form-group">
<label>Company name</label>
<input class="form-control" type="text" name="company" autocomplete="off"  required />
</div>


<div class="form-group">
<label>Role</label>
<input class="form-control" type="text" name="roles" autocomplete="off"  required />
</div>


<div class="form-group">
<label>Salary</label>
<input class="form-control" type="text" name="salary" autocomplete="off"  required />
</div>


<div class="form-group">
<label>Location</label>
<input class="form-control" type="text" name="locations" autocomplete="off"  required />
</div>


<div class="form-group">
<label>Mobile No</label>
<input class="form-control" type="text" name="mobileno" autocomplete="off"  required />
</div>


<div class="form-group">
<label>Email Id</label>
<input class="form-control" type="text" name="emailid" autocomplete="off"  required />
</div>


<button type="submit" name="submit" id="submit" class="btn btn-info">Submit </button>

                                    </form>
                            </div>
                        </div>
                            </div>

        </div>
   
    </div>
    </div>
     <!-- CONTENT-WRAPPER SECTION END-->
  <?php include('includes/footer.php');?>
      <!-- FOOTER SECTION END-->
    <!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY  -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
      <!-- CUSTOM SCRIPTS  -->
    <script src="assets/js/custom.js"></script>

</body>
</html>
<?php ?>
