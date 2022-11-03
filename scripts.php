<?php
    //INCLUDE DATABASE FILE
    require('database.php');
    //SESSSION IS A WAY TO STORE DATA TO BE USED ACROSS MULTIPLE PAGES
    session_start();

    //ROUTING
    if(isset($_POST['save']))        saveTask();
    if(isset($_POST['update']))      updateTask();
    if(isset($_POST['delete']))      deleteTask();
    

    function getTasks($inpStatus){
        //SQL SELECT QUERY
        $sql = "SELECT tasks.id, title, types.name as types, priorities.name as priority, statuses.name as statuss, task_datetime, description
        FROM tasks
        INNER JOIN types 
        ON types.id = tasks.type_id
        INNER JOIN priorities
        ON priorities.id = tasks.priority_id
        INNER JOIN statuses
        ON statuses.id = tasks.status_id
        WHERE statuses.name = '$inpStatus'
        ORDER BY tasks.id";
        //PERFORM THE QUERY AND GET RESULT
        $result = mysqli_query($GLOBALS['conn'],$sql);
        if($result ->num_rows > 0)
        {
            //FETCH DATA AS ASSOCIATIVE ARRAY
            while($row = $result->fetch_assoc())
            {
                if($row['statuss'] == 'To Do')
                {
                    $icon = "bi bi-question-circle text-success fs-4";
                }
                else if($row['statuss'] == 'In Progress')
                {
                    $icon = "spinner-border spinner-border-sm text-success";
                }
                else
                {
                    $icon = "bi bi-check2-circle text-success fs-3";
                }
                echo "<button id=".$row['id']." class='row list-group-item-action mx-0 border' onclick='editTask(this.id)'>
                <div class='col-1 m-auto'>
                    <i class='".$icon."'></i> 
                </div>
                <div class='col-11'>
                    <div class='fs-6 text-dark fw-bolder'>".$row['title']."</div>
                    <div class=''>
                        <div class='text-secondary'>#".$row['id']." created in ".substr($row['task_datetime'],0,10)."</div>
                        <div class='text-truncate' title=".$row['description'].">".$row['description']."</div>
                    </div>
                    <div class='mt-1 mb-2'>
                        <span class='btn-primary px-2 py-1 rounded fw-bolder' style='font-size:0.6rem'>".$row['priority']."</span>
                        <span class='bg-light-600 rounded fw-bolder px-2 py-1' style='font-size:0.6rem'>".$row['types']."</span>
                    </div>
                </div>
            </button>";}}
    }


    function saveTask()
    {
        //form validation
        $errors = array();
        //Check if all fields are filled
        if(empty($_POST['title']))      $errors['title'] = "Title is required";
        if(empty($_POST['description']))$errors['description'] = "Description is required";
        if(empty($_POST['type']))       $errors['type'] = "Type is required";
        if(empty($_POST['priority']))   $errors['priority'] = "Priority is required";
        if(empty($_POST['status']))     $errors['status'] = "Status is required";
        if(empty($_POST['date']))       $errors['date'] = "Date is required";
        
        //Check if there are errors
        if (count($errors) == 0)
        {
            //SQL insert query if there are no errors
            $title = $_POST['title'];
            $description = $_POST['description'];
            $type = $_POST['type'];
            $priority = $_POST['priority'];
            $status = $_POST['status'];
            $task_datetime = $_POST['date'];
            $sql = "INSERT INTO tasks (title, description, type_id, priority_id, status_id, task_datetime) VALUES ('$title', '$description', '$type', '$priority', '$status', '$task_datetime')";
            if(mysqli_query($GLOBALS['conn'],$sql))
            {
                $_SESSION['message'] = "Task has been added successfully !";
                $_SESSION['msg_type'] = "success";
                header('location: index.php');
            }
            else
            {
                $_SESSION['message'] = "Task has not been added !";
                $_SESSION['msg_type'] = "danger";
                header('location: index.php');
            }
        }
        else
        {
            //If there are errors, redirect to index.php with errors
            //Empty fields alerts
            $_SESSION['titleErr'] = $errors['title'];
            $_SESSION['descriptionErr'] = $errors['description'];
            $_SESSION['typeErr'] = $errors['type'];
            $_SESSION['priorityErr'] = $errors['priority'];
            $_SESSION['statusErr'] = $errors['status'];
            $_SESSION['dateErr'] = $errors['date'];
            //launch js script to show already filled fields in modal
            $_SESSION['error'] = "<script type = text/javascript>
            createTask(); 
            document.getElementById('taskTitle').value ='".$_POST['title']."' ;
            document.getElementById('description').value = '".$_POST['description']."';
            if (".$_POST['type']."=='1')
            {document.getElementById('feature').checked=true;}
            else {document.getElementById('bug').checked=true;}
            document.getElementById('priority').value = '".$_POST['priority']."';
            document.getElementById('status').value = '".$_POST['status']."';
            document.getElementById('date').value = '".$_POST['date']."';
            </script>";
            header('location: index.php');
        }
    }

    function updateTask()
    {
        //SQL update query
        $id = $_POST['taskId'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $type = $_POST['type'];
        $priority = $_POST['priority'];
        $status = $_POST['status'];
        $task_datetime = $_POST['date'];
        $sql = "UPDATE tasks SET title = '$title', description = '$description', type_id = '$type', priority_id = '$priority', status_id = '$status', task_datetime = '$task_datetime' WHERE id = '$id'";
        mysqli_query($GLOBALS['conn'],$sql);

        $_SESSION['message'] = "Task has been updated successfully !";
        $_SESSION['msg_type'] = "success";
		header('location: index.php');
    }

    function deleteTask()
    {
        //SQL delete query
        $id = $_POST['taskId'];
        $sql = "DELETE FROM tasks WHERE id='$id'";
        mysqli_query($GLOBALS['conn'],$sql);
        
        $_SESSION['message'] = "Task has been deleted successfully !";
        $_SESSION['msg_type'] = "success";
		header('location: index.php');
    }
?>