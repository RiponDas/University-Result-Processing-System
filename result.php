<?php
session_start();
error_reporting(0);
include('includes/config.php');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
        <title>University Result Processing System</title>
        <link rel="stylesheet" href="css/bootstrap.min.css" media="screen" >
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen" >
        <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen" >
        <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen" >
        <link rel="stylesheet" href="css/prism/prism.css" media="screen" >
        <link rel="stylesheet" href="css/main.css" media="screen" >
        <script src="js/modernizr/modernizr.min.js"></script>
    </head>
    <body>
        <div class="main-wrapper">
            <div class="content-wrapper">
                <div class="content-container">

         
                    <!-- /.left-sidebar -->

                    <div class="main-page">
                        <div class="container-fluid">
                            <div class="row page-title-div">
                                <div class="col-md-12">
                                    <h2 class="title" align="center">University Result Processing System</h2>
                                </div>
                            </div>
                            <!-- /.row -->
                          
                            <!-- /.row -->
                        </div>
                        <!-- /.container-fluid -->

                        <section class="section">
                            <div class="container-fluid">

                                <div class="row">
                              
                             

                                    <div class="col-md-8 col-md-offset-2">
                                        <div class="panel">
                                            <div class="panel-heading">
                                                <div class="panel-title">
<?php
// code Student Data
$rollid=$_POST['rollid'];
$classid=$_POST['exam'];
$_SESSION['rollid']=$rollid;
$_SESSION['classid']=$classid;
$qery = "SELECT   Name,examRoll from student where examRoll=:rollid";
$stmt = $dbh->prepare($qery);
$stmt->bindParam(':rollid',$rollid,PDO::PARAM_STR);
$stmt->execute();
$resultss=$stmt->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($stmt->rowCount() > 0)
{
foreach($resultss as $row)
{   ?>


<table border="0px">
<tr>
<td colspan="3" style="text-align:center"><h2 style="text-align:center"><b>UNIVERSITY OF BARISAL</b></h2></td>
</tr>
<tr>
<td><img src="images/markdist.jpg" height="150" width="80" align="center"></td>
<td style="text-align:center" ><img src="images/logobu.jpg" height="50" width="50"><br>
<b>Academic Transcript</b><br>5th Semester B S (Hons) Examination of 2017<br>Session: 2014-15</td>
<td><img src="images/markdist.jpg" height="150" width="100" style="text-align:center;display:none"></td>
</tr>
<tr>
<td  colspan="3" style="text-align:center"><b>Subject: Computer Science and Engineering</b></td>
</tr>
<tr>
<td colspan="3"><p><i>The following are the grades obtained by <b><?php echo htmlentities($row->Name);?></b>  Examination Roll No. <b><?php echo htmlentities($row->examRoll);?></b>  at the 5th Semester B S (Hons) Examination held in 2017</i></p></td>
</tr>
</table>


<?php }

    ?>
                                            </div>
                                            <div class="panel-body p-20">







                                                <table class="table table-hover table-bordered">
                                                <thead>
                                                        <tr>
                                                            <th>SL</th>
                                                            <th>Course Code</th>    
                                                            <th>Course Title</th>    
                                                            <th>Credit</th>
                                                            <th>Letter Grade</th>
                                                            <th>Grade Point</th>
                                                            
                                                        </tr>
                                               </thead>
  


                                                	
                                                	<tbody>
<?php                                              
// Code for result

 $query ="SELECT tblsubjects.SubjectCode, SubjectId, Credit, LG, GP FROM tblresult JOIN tblsubjects ON tblresult.SubjectId = tblsubjects.SubjectName AND tblresult.StudentId=:rollid AND tblresult.ClassId=:classid";
$query= $dbh -> prepare($query);
$query->bindParam(':rollid',$rollid,PDO::PARAM_STR);
$query->bindParam(':classid',$classid,PDO::PARAM_STR);
$query-> execute();  
$results = $query -> fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($countrow=$query->rowCount()>0)
{ 

foreach($results as $result){

    ?>

                                                		<tr>
                                                <th scope="row"><?php echo htmlentities($cnt);?></th>
                                                			<td><?php echo htmlentities($result->SubjectCode);?></td>
                                                			<td><?php echo htmlentities($result->SubjectId);?></td>
                                                			<td><?php echo htmlentities($credit=$result->Credit);?></td>
                                                			<td><?php echo htmlentities($result->LG);?></td>
                                                			<td><?php echo htmlentities($gpc=$result->GP);?></td>
                                                		</tr>
<?php 
$totalcredit+=$credit;
$totalgp+=($credit*$gpc);
$cnt++;}
?>
<tr>
                                                <th scope="row" colspan="4">GPA</th>
<td colspan="2"><b><?php echo htmlentities($totalgpa=($totalgp/$totalcredit)); ?></b> out of <b><?php echo htmlentities(4); ?></b></td>
                                                        </tr>


 <?php } else { ?>     
<div class="alert alert-warning left-icon-alert" role="alert">
                                            <strong>Notice!</strong> Your result not declare yet
 <?php }
?>
                                        </div>
 <?php 
 } else
 {?>

<div class="alert alert-danger left-icon-alert" role="alert">
<strong>Oh snap!</strong>
<?php
echo htmlentities("Invalid Roll Id");
 }
?>
                                        </div>



                                                	</tbody>
                                                </table>
												<table width="75%">
												<tr>
												<td><p>University of Barisal<br>Barisal, Bangladesh<br>Website: barisaluniv.edu.bd</p></td>
												<td><p>Prepared By..............<br>Compared By............</p></td>
												<td><p>Controller of Examination<br>University of Barisal</p></td>
												
												</tr>
												</table>

                                            </div>
                                        </div>
                                        <!-- /.panel -->
                                    </div>
                                    <!-- /.col-md-6 -->

                                    <div class="form-group">
                                                           
                                                            <div class="col-sm-6">
                                                               <a href="index.php">Back to Home</a>
                                                            </div>
                                                        </div>

                                </div>
                                <!-- /.row -->
  
                            </div>
                            <!-- /.container-fluid -->
                        </section>
                        <!-- /.section -->

                    </div>
                    <!-- /.main-page -->

                  
                </div>
                <!-- /.content-container -->
            </div>
            <!-- /.content-wrapper -->

        </div>
        <!-- /.main-wrapper -->

        <!-- ========== COMMON JS FILES ========== -->
        <script src="js/jquery/jquery-2.2.4.min.js"></script>
        <script src="js/bootstrap/bootstrap.min.js"></script>
        <script src="js/pace/pace.min.js"></script>
        <script src="js/lobipanel/lobipanel.min.js"></script>
        <script src="js/iscroll/iscroll.js"></script>

        <!-- ========== PAGE JS FILES ========== -->
        <script src="js/prism/prism.js"></script>

        <!-- ========== THEME JS ========== -->
        <script src="js/main.js"></script>
        <script>
            $(function($) {

            });
        </script>

        <!-- ========== ADD custom.js FILE BELOW WITH YOUR CHANGES ========== -->

    </body>
</html>
