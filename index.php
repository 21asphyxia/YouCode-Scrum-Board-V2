<?php
    include('scripts.php');
?>

<!DOCTYPE html>
<html lang="en" >
<head>
	<meta charset="utf-8">
	<title>YouCode | Scrum Board</title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport">
	<meta content="" name="description">
	<meta content="" name="author">
	
	<!-- ================== BEGIN core-css ================== -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
	<link href="assets/css/vendor.min.css" rel="stylesheet">
	<link href="assets/css/default/app.min.css" rel="stylesheet">
	<link href="assets/css/style.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
	<!-- ================== END core-css ================== -->
</head>
<body>

	<!-- BEGIN #app -->
	<div id="app" class="app-without-sidebar">
		<!-- BEGIN #content -->
		<div id="header" class="app-header app-header-inverse">
						<!-- BEGIN navbar-header -->
						<div class="navbar-header">
							<a href="https://youcode.ma/" class="navbar-brand">
								<img src="assets/img/logo-white.png" alt="youcode logo"> 
								<small >APPRENANT</small>
							</a>
						</div>
						<div class="navbar-nav">
							<div class="navbar-item dropdown">
									<i class="fa fa-bell text-white"></i>
							</div>
							<div class="navbar-item navbar-user ">
								<a href="https://github.com/21asphyxia/YouCode-Scrum-Board" class="navbar-link dropdown-toggle d-flex align-items-center">
									<img src="assets/img/334-1662714630.jpg" alt="" class="rounded"> 
									<span class="d-none d-md-inline text-white">Mouad El Amraoui</span>
								</a>
							</div>
						</div>
						<!-- END header-nav -->
		</div>
		<div id="content" class="app-content main-style">
			<div class="navbar">
				<div class="">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
						<li class="breadcrumb-item active">Scrum Board </li>
					</ol>
					<!-- BEGIN page-header -->
					<h1 class="page-header">
						Scrum Board 
					</h1>
					<!-- END page-header -->
				</div>
				
				<div class="">
					<div id="add-button" class="btn btn-success rounded-pill"><i class="fa fa-plus" style="color: rgb(0, 109, 115)"></i> Add Task</div>
				</div>
			</div>
			<!-- add,delete, update alert -->
			<?php if (isset($_SESSION['message'])){
				echo "<div ";

				 if ($_SESSION['msg_type'] == "success") 
				{echo "class='alert alert-green alert-dismissible fade show' >
					<strong>Success! </strong>";}
				else { echo "class='alert alert-red alert-dismissible fade show' >
					<strong>Failure! </strong>";}
					
						echo $_SESSION['message']; 
						unset($_SESSION['message']);
					
					echo '<button type="button" class="btn-close" data-bs-dismiss="alert"></span>
				</div>';
				} ?>
			<div class="row gy-3">
				<div class="col-xl-4 col-md-6">
					<div class="">
						<div class="text-white bg-dark rounded-xl">
							<h4 class="p-2 fs-6">To do (<span id="to-do-tasks-count">
								<?php 
								$sql = "SELECT * FROM tasks WHERE status_id = 1";
								global $conn;
								$result = mysqli_query($conn, $sql);
								$toDoTasksCount = mysqli_num_rows($result);
								echo "$toDoTasksCount"?>
							</span>)</h4>
							
						</div>
						<div class="list-group " id="to-do-tasks" ondrop="dropToDo(event)" ondragover="allowDrop(event)">
							<!-- TO DO TASKS HERE -->
							<?php getTasks('To Do')?>
						</div>
					</div>
				</div>
				<div class="col-xl-4 col-md-6">
					<div class="">
						<div class="text-white bg-dark rounded-xl">
							<h4 class="p-2 fs-6">In Progress (<span id="in-progress-tasks-count">
							<?php 
								$sql = "SELECT * FROM tasks WHERE status_id = 2";
								global $conn;
								$result = mysqli_query($conn, $sql);
								$toDoTasksCount = mysqli_num_rows($result);
								echo "$toDoTasksCount"?>
							</span>)</h4>

						</div>
						<div class="list-group " id="in-progress-tasks" ondrop="dropInProgress(event)" ondragover="allowDrop(event)">
							<!-- IN PROGRESS TASKS HERE -->
							<?php getTasks('In Progress')?>
						</div>
					</div>
				</div>
				<div class="col-xl-4 col-md-6">
					<div class="">
						<div class="text-white bg-dark rounded-xl">
							<h4 class="p-2 fs-6">Done (<span id="done-tasks-count">
							<?php 
								$sql = "SELECT * FROM tasks WHERE status_id = 3";
								global $conn;
								$result = mysqli_query($conn, $sql);
								$toDoTasksCount = mysqli_num_rows($result);
								echo "$toDoTasksCount"?>
							</span>)</h4>

						</div>
						<div class="list-group" id="done-tasks" ondrop="dropDone(event)" ondragover="allowDrop(event)">
							<!-- DONE TASKS HERE -->
							<?php getTasks('Done')?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- END #content -->
		
		
		<!-- BEGIN scroll-top-btn -->
		<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top" data-toggle="scroll-to-top"><i class="fa fa-angle-up"></i></a>
		<!-- END scroll-top-btn -->
	</div>
	<!-- END #app -->
	
	<!-- TASK MODAL -->
	<form class="modal fade " id="form" tabindex="-1" action="scripts.php" method="post">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Add Task</h5>
					<button type="button" id="close-button" class="btn-close" data-bs-dismiss="modal"></button>
				</div>
				<div class="modal-body">
					<input type="hidden" name="taskId" id="task-id">
					<div class="mb-3">
						<label class="col-form-label">Title</label>
						<input type="text" class="form-control" onkeyup="enableADD()" onCut="return false" id="taskTitle" name="title">
						<?php if(isset($_SESSION['titleErr'])){
							echo '<div class="alert alert-red mt-2" role="alert">'.$_SESSION['titleErr'].'</div>';
							unset($_SESSION['titleErr']);
						}?>
						<div id="msg"></div>
					</div>
					<div class="mb-3">
						<label class="col-form-label">Type</label>
						<div class="form-check ms-3">
							<input class="form-check-input" type="radio" value="1" name="type" id="feature" checked>
							<label class="form-check-label" for="feature">Feature</label>
						</div>
						<div class="form-check ms-3">
							<input class="form-check-input" type="radio" value="2" name="type" id="bug">
							<label class="form-check-label" for="bug">Bug</label>
						</div>
						<?php if(isset($_SESSION['typeErr'])){
							echo '<div class="alert alert-red mt-2" role="alert">'.$_SESSION['typeErr'].'</div>';
							unset($_SESSION['typeErr']);
						}?>
					</div>
					<div class="mb-3">
						<label class="col-form-label">Priority</label>
						<select class="form-select" id="priority" name="priority">
							<option selected disabled hidden value="default">Please select</option>
							<option value="1">Low</option>
							<option value="2">Medium</option>
							<option value="3">High</option>
							<option value="4">Critical</option>
						</select>
						<?php if(isset($_SESSION['priorityErr'])){
							echo '<div class="alert alert-red mt-2" role="alert">'.$_SESSION['priorityErr'].'</div>';
							unset($_SESSION['priorityErr']);
						}?>
					</div>
					<div class="mb-3">
						<label class="col-form-label">Status</label>
						<select id="status" class="form-select" name="status">
							<option selected disabled hidden value="default">Please select</option>
							<option value="1">To do</option>
							<option value="2">In progress</option>
							<option value="3">Done</option>
						</select>
						<?php if(isset($_SESSION['statusErr'])){
							echo '<div class="alert alert-red mt-2" role="alert">'.$_SESSION['statusErr'].'</div>';
							unset($_SESSION['statusErr']);
						}?>
					</div>
					<div class="mb-3">
						<label class="col-form-label">Date</label>
						<input type="date" class="form-control" id="date" name="date">
						<?php if(isset($_SESSION['dateErr'])){
							echo '<div class="alert alert-red mt-2" role="alert">'.$_SESSION['dateErr'].'</div>';
							unset($_SESSION['dateErr']);
						}?>
					</div>
					<div class="mb-3">
						<label class="col-form-label">Description</label>
						<textarea class="form-control" rows="5" id="description" name="description"></textarea>
						<?php if(isset($_SESSION['descriptionErr'])){
							echo '<div class="alert alert-red mt-2" role="alert">'.$_SESSION['descriptionErr'].'</div>';
							unset($_SESSION['descriptionErr']);
						}?>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-light text-black border" data-bs-dismiss="modal" id="cancel-button">Cancel</button>
					<button type="button" name="delete" class="btn btn-outline-danger border" id="delete-button">Delete</button>
					<button type="submit" name="delete" class="d-none" id="hiddenDelete">Delete</button>
					<button type="submit" name="save" id="save-button" class="btn btn-primary" disabled>Save</button>
					<button type="submit" name="update" class="btn btn-primary" id="update-button">Update</button>
				</div>
			</div>
		</div>
	</form>
	
	<!-- ================== BEGIN core-js ================== -->
	<script src="assets/js/vendor.min.js"></script>
	<script src="assets/js/app.min.js"></script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<!-- ================== END core-js ================== -->
	 <script src="assets/js/data.js"></script>
	<script src="assets/js/app.js"></script>
	<?php
	if(isset($_SESSION['error'])){
		echo $_SESSION['error'];
		unset($_SESSION['error']);
	}
	 ?>
</body>
</html>