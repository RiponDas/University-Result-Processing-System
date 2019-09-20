<?php
include('includes/config.php');
if(!empty($_POST["classid"])) 
{
 $cid=$_POST['classid'];
 if(is_numeric($cid)){
 
 	echo htmlentities("invalid Class");exit;
 }
 else{
 $stmt = $dbh->prepare("SELECT SubjectCode FROM tblsexamsemester WHERE SubjectName= :id order by SubjectCode");
 $stmt->execute(array(':id' => $cid));
 ?><?php
 while($row=$stmt->fetch(PDO::FETCH_ASSOC))
 {
  ?>
  <option value="<?php echo htmlentities($row['SubjectCode']); ?>"><?php echo htmlentities($row['SubjectCode']); ?></option>
  <?php
 }
}

}
// Code for Subjects
if(!empty($_POST["classid1"])) 
{
 $cid1=$_POST['classid1'];
 if(is_numeric($cid1)){
 
  echo htmlentities("invalid Semester");exit;
 }
 else{
 $status=0;	
 $stmt = $dbh->prepare("SELECT tblsubjects.SubjectName FROM tblsubjectcombination join  tblsubjects on  tblsubjects.SubjectName=tblsubjectcombination.SubjectId WHERE tblsubjectcombination.ClassId=:cid and tblsubjectcombination.status!=:stts order by tblsubjects.SubjectName");
 $stmt->execute(array(':cid' => $cid1,':stts' => $status));
 
 while($row=$stmt->fetch(PDO::FETCH_ASSOC))
 {?>
  <label> <?php echo htmlentities($row['SubjectName']); ?></label>
  <table>
  <tr>
  <td><input type="text"  name="marks[]" value="" class="" required="" placeholder="Internal 40" autocomplete="off"></td>
  <td><input type="text"  name="marks1[]" value="" class="" required="" placeholder="First Examinar(60)" autocomplete="off"></td>
  </tr>
  <tr>
  <td><input type="text"  name="marks2[]" value="" class="" required="" placeholder="Second Examinar(60)" autocomplete="off"></td>
  <td><input type="text"  name="marks3[]" value="" class=""  placeholder="Third Examinar(60)" autocomplete="off"></td>
  </tr>
  </table>
 
<?php  }
}
}


?>

<?php

if(!empty($_POST["studclass"])) 
{
 $id= $_POST['studclass'];
 $dta=explode("$",$id);
$id=$dta[0];
$id1=$dta[1];
 $query = $dbh->prepare("SELECT StudentId,ClassId FROM tblresult WHERE StudentId=:id1 and ClassId=:id ");
//$query= $dbh -> prepare($sql);
$query-> bindParam(':id1', $id1, PDO::PARAM_STR);
$query-> bindParam(':id', $id, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query -> rowCount() > 0)
{ ?>
<p>
<?php
echo "<span style='color:red'> Result Already Declare .</span>";
 echo "<script>$('#submit').prop('disabled',true);</script>";
 ?></p>
<?php }


  }?>


