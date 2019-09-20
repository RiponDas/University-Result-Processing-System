<?php
namespace Dompdf;
require_once 'dompdf/autoload.inc.php';
session_start();
ob_start();
require_once('includes/configpdo.php');
error_reporting(0);
?>

<html>
<style>
body {
  padding: 4px;
  text-align: center;
}

table {
  width: 100%;
  margin: 10px auto;
  table-layout: auto;
}

.fixed {
  table-layout: fixed;
}

table,
td,
th {
  border-collapse: collapse;
}

th,
td {
  padding: 1px;
  border: solid 1px;
  text-align: center;
}


</style>
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
<p><b>Student Name :</b> <?php echo htmlentities($row->Name);?></p>
<p><b>Student Exam Roll :</b> <?php echo htmlentities($row->examRoll);?>

<?php }

    ?>
                                            </div>
                                            <div class="panel-body p-20">







                                                <table class="table table-hover table-bordered">
                                                <thead>
                                                        <tr>
                                                            <th>#</th>
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
                                                <th scope="row" colspan="2">GPA</th>
<td><b><?php echo htmlentities($totalgpa=($totalgp/$totalcredit)); ?></b> out of <b><?php echo htmlentities(4.00); ?></b></td>
                                                        </tr>
<tr>
                                                <th scope="row" colspan="2">Download Result</th>           
                                                            <td><b><a href="download-result.php">Download </a> </b></td>
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

                                            </div>
                                        </div>
                                        <!-- /.panel -->
                                    </div>
</html>

<?php
$html = ob_get_clean();
$dompdf = new DOMPDF();
$dompdf->setPaper('A4', 'landscape');
$dompdf->load_html($html);
$dompdf->render();
//dompdf->stream("",array("Attachment" => false));
$dompdf->stream("result");
?>