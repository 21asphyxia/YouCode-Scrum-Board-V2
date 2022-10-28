<?php
    //INCLUDE DATABASE FILE
    include_once('database.php');
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
        // echo "Fetch all tasks";
    }


    function saveTask()
    {
        //CODE HERE
        $title = $_POST['title'];
        $description = $_POST['description'];
        $type = $_POST['type'];
        $priority = $_POST['priority'];
        $status = $_POST['status'];
        $task_datetime = $_POST['date'];
        $sql = "INSERT INTO tasks (title, description, type_id, priority_id, status_id, task_datetime) VALUES ('$title', '$description', '$type', '$priority', '$status', '$task_datetime')";
        if(mysqli_query($GLOBALS['conn'],$sql))
        {
            echo "New record created successfully";
        }
        else
        {
            echo "Error: " . $sql . "<br>" . mysqli_error($GLOBALS['conn']);
        }

        //SQL INSERT
        $_SESSION['message'] = "Task has been added successfully !";
		header('location: index.php');
    }

    function updateTask()
    {
        //CODE HERE
        $id = $_POST['taskId'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $type = $_POST['type'];
        $priority = $_POST['priority'];
        $status = $_POST['status'];
        $task_datetime = $_POST['date'];
        $sql = "UPDATE tasks SET id = '$id',title = '$title', description = '$description', type_id = '$type', priority_id = '$priority', status_id = '$status', task_datetime = '$task_datetime' WHERE id = '$id'";
        mysqli_query($GLOBALS['conn'],$sql);
        //SQL UPDATE
        $_SESSION['message'] = "Task has been updated successfully !";
		header('location: index.php');
    }

    function deleteTask()
    {
        //CODE HERE
        $id = $_POST['taskId'];
        //SQL DELETE
        $sql = "DELETE FROM tasks WHERE id='$id'";
        mysqli_query($GLOBALS['conn'],$sql);
        
        $_SESSION['message'] = "Task has been deleted successfully !";
		header('location: index.php');
    }

?>




