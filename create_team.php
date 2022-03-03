<?php
session_start();
include 'connect.php';
if(isset($_SESSION['user_data'])){
	if($_SESSION['user_data']['usertype']!=1){
		header("Location:student_home.php");
	}
if(isset($_POST['submit'])){

	$teamname = $_POST['teamname'];
	$leadername = $_POST['leadername'];
	$member1 = $_POST['member1'];
	$member2 = $_POST['member2'];
	$projectTitle = $_POST['projectTitle'];

	$qrr = mysqli_query($con,"INSERT INTO `teams`(`name`, `project`, `leader`, `mem1`, `mem2`) VALUES ('$teamname','$projectTitle','$leadername','$member1','$member2')");

}	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Create Team</title>
	<?php include 'css.php'; ?>
</head>
<body>
	<form action="create_team.php" method="post">
	<div class="container">
		<div class="row">
			<a href="index.php" class="btn btn-success" style="margin:10px;">Home</a>
		</div>
		<div class="row">
   		<?php if(isset($_REQUEST['error'])){ ?>
   		<div class="col-lg-12">
   			<span class="alert alert-danger" style="display: block;"><?php echo $_REQUEST['error']; ?></span>
   		</div>
	   	<?php } ?>
	   	</div>
	   	<div class="row">
   		<?php if(isset($_REQUEST['success'])){ ?>
   		<div class="col-lg-12">
   			<span class="alert alert-success" style="display: block;"><?php echo $_REQUEST['success']; ?></span>
   		</div>
	   	<?php } ?>
	   	</div>
		<div class="row">
			<h2 style="margin:15px;" class="text-center">Create Team</h2>
		</div>
		<div class="row">
			<div class="col-lg-12 form-group">
				<input type="text" name="teamname" id="teamname" placeholder="Team Name" required="required" class="form-control">
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 form-group">
				<input type="text" name="leadername" id="leadername" placeholder="Leader Name" required="required" class="form-control">
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 form-group">
				<input type="text" name="member1" id="member1" placeholder="Member 1" required="required" class="form-control">
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 form-group">
				<input type="text" name="member2" id="member2" placeholder="Member 2" required="required" class="form-control">
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 form-group">
				<input type="text" name="projectTitle" id="projectTitle" placeholder="Project Title" required="required" class="form-control">
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 form-group">
				<input type="submit" name="submit" class="btn btn-success btn-block" value="Create Team">
			</div>
		</div>
	</div>
	</form>
		   
</body>
</html>
<?php
}