<?php
//application functions
function get_project_list(){
    include 'connection.php';
    try{
       return $db->query('SELECT project_id, title, category FROM projects');
    }catch(Exception $e){
        echo "Error: " . $e->getMessage() . "</br>";
        return array(); // not to return notice about not being an arr: the correct data is arr
    }
}

function get_task_list($filter=null){
    include 'connection.php';
    $sql = 'SELECT tasks.*, projects.title AS project FROM tasks'
            . ' JOIN projects ON tasks.project_id = projects.project_id';
    $orderBy = 'ORDER BY date DESC';
    if($filter){
        $orderBy = 'ORDER BY projects.title ASC, date DESC';
    }

    try{
       $result = $db->prepare($sql . $orderBy);
       $result->execute();
    }catch(Exception $e){
        echo "Error: " . $e->getMessage() . "</br>";
        return array(); // not to return notice about not being an arr: the correct data is arr
    }
}

function add_project($title, $category){
    include 'connection.php';
    $sql = 'INSERT INTO projects(title, category) VALUES(?, ?)';
    try{
        $result = $db->prepare($sql);
        $result->bindValue(1,$title, PDO :: PARAM_STR);
        $result->bindValue(2, $category, PDO::PARAM_STR);
        $result->execute();
    }catch(Exception $e){
         echo "Error! : " . $e->getMessage() . "</br>";
         return false;
    } 
    return true;
}

function add_task($project_id, $title, $date, $time){
    include 'connection.php';
    $sql = 'INSERT INTO tasks(project_id, title, date, time) VALUES(?, ?, ?, ?)';
    try{
        $result = $db->prepare($sql);
        $result->bindValue(1, $project_id, PDO::PARAM_INT);
        $result->bindValue(2,$title, PDO :: PARAM_STR);
        $result->bindValue(3, $date, PDO::PARAM_STR);
        $result->bindValue(4, $time, PDO::PARAM_INT);
        $result->execute();
    }catch(Exception $e){
         echo "Error! : " . $e->getMessage() . "</br>";
         return false;
    } 
    return true;
}

