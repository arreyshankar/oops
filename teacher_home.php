<?php
session_start();
include 'connect.php';
if(isset($_SESSION['user_data'])){
	if($_SESSION['user_data']['usertype']!=1){
		header("Location:student_home.php");
	}

	$data=array();
	$qr=mysqli_query($con,"select * from teams");
	while($row=mysqli_fetch_assoc($qr)){
		array_push($data,$row);
	}

	$data1=array();
	$qrr=mysqli_query($con,"select * from users where usertype='2' && team_id='0'");
	while($row1=mysqli_fetch_assoc($qrr)){
		array_push($data1,$row1);
	}

if(isset($_POST['save'])){

	$title = $_POST['title'];
	$dateofsub = $_POST['submitdate'];
	$desc = $_POST['description'];

	$filename = $_FILES['myfile']['name'];
    $destination = 'uploads/' . $filename;
    $extension = pathinfo($filename, PATHINFO_EXTENSION);
   
    $file = $_FILES['myfile']['tmp_name'];
    $size = $_FILES['myfile']['size'];

    if (!in_array($extension, ['zip', 'pdf', 'docx'])) {
        echo "You file extension must be .zip, .pdf or .docx";
    } elseif ($_FILES['myfile']['size'] > 1000000) { 
        echo "File too large!";
    } else {
       
        if (move_uploaded_file($file, $destination)) {
            
                echo "File uploaded successfully";
            
        } else {
            echo "Failed to upload file.";
        }
    }

	
	

	$qrr = mysqli_query($con,"insert into projects (`title`, `teacher_id`, `dateofsub`, `description`, `file`) VALUES ('$title','1','$dateofsub','$desc','$filename')");
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Teacher Home</title>
	<?php include 'css.php'; ?>
</head>
<body>
<div class="container">

	<div class="row">
   		<?php if(isset($_REQUEST['error'])) { ?>
   		<div class="col-lg-12">
   			<span class="alert alert-danger" style="display: block;">
   				<?php echo $_REQUEST['error']; ?>	
			</span>
   		</div>
	   	<?php } ?>
	 </div>
	 <div class="row">
   		<?php if(isset($_REQUEST['success'])) { ?>
   		<div class="col-lg-12">
   			<span class="alert alert-success" style="display: block;">
   				<?php echo $_REQUEST['success']; ?>	
			</span>
   		</div>
	   	<?php } ?>
	 </div>
	<div class="row">
		<a href="create_team.php" class="btn btn-success" style="margin:10px;">Create Team</a>
		<a href="logout.php" class="btn btn-success" style="margin:10px;">Logout</a>
	</div>
	<h1>Current Teams:</h1>
	<div class="row">
		<div class="col-lg-12">
			<div>
			<table class="table table-bordered">
				<tr>
					<th>Project Title</th>
					<th>Leader</th>
					<th>Team</th>
					<th>Members</th>
					<th>Action</th>												
				</tr>
				<?php
				  foreach($data as $d) {
				 ?>
				 <tr>
					<td><?php echo $d['project']; ?></td>
				 	<td><?php echo $d['leader']; ?></td>
				 	<td><?php echo $d['name']; ?></td>
				 	<td><?php echo $d['mem1'] .", ". $d['mem2']; ?></td>	 	
				 	<td><a class="btn btn-info" href="edit_result.php?id=<?php echo $d['leader']; ?>">Manage</a></td>	 	
				 </tr>
				 <?php
				  } 
				?>
			</table>
			</div>
		</div>
	</div>
</div>

<div class="container">
<form action="teacher_home.php" method="post" enctype="multipart/form-data">
	<h1>Create Assignment:</h1>
	<label for="title">Project Title:</label><br>
  <input type="text" id="title" name="title"><br><br>
  <label for="submitdate">Last Date of Submission:</label><br>
  <input type="date" id="submitdate" name="submitdate"><br><br>
  <label for="title">Project Description:</label><br>
  <textarea name="description" id="description" cols="100" rows="10"></textarea><br><br>
  <label for="fileToUpload">Select File to Upload:</label><br>
          <h3>Upload File</h3>
          <input type="file" name="myfile"> <br>
          <button type="submit" name="save">Post Assignment</button>
</form>
</div>

<div class="container">
	<br>
	<h1>Unlisted Students (not in team):</h1><br>
	<div class="row">
		<div class="col-lg-12">
			<div>
			<table class="table table-bordered">
				<tr>
					<th>Roll</th>
					<th>Name</th>
					<th>Email</th>												
				</tr>
				<?php
				  foreach($data1 as $d) {
				 ?>
				 <tr>
					<td><?php echo $d['id']; ?></td>
				 	<td><?php echo $d['name']; ?></td>
				 	<td><?php echo $d['email']; ?></td>
				 </tr>
				 <?php
				  } 
				?>
			</table>
			</div>
		</div>
	</div>

	</div>
</body>
</html>
<?php
}
else{
	header("Location:index.php?error=UnAuthorized Access");
}