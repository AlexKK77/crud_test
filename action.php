<?php
session_start();

$mysqli = new mysqli('localhost','root','','crud');
$id = 0;
$update = false;
$name = "";
$phone = "";
$result_search = "";

if ($mysqli->connect_errno) {
    echo 'Error. Please try later...';
    exit();
}

$result = $mysqli->query("SELECT * FROM data");

//add btn
if(isset($_POST['add'])){
    unset($_SESSION['sid']);
    $name = $_POST['name'];
    $phone = $_POST['phone'];

    $mysqli->query("INSERT INTO data (name, phone) VALUES ('$name','$phone')");

    $_SESSION['msg'] = "Number has been added";
    header("location: index.php");
}

//delete btn
if(isset($_GET['del'])){
    unset($_SESSION['sid']);
    $id = $_GET['del'];

    $mysqli->query("DELETE FROM data WHERE id=$id");

    $_SESSION['msg'] = "Number has been deleted";
    header("location: index.php");
}

//edit btn
if(isset($_GET['edit'])){
    $update = true;
    $id = $_GET['edit'];

    $result_edit = $mysqli->query("SELECT * FROM data WHERE id=$id");

    if (count(array($result_edit)) == 1 ) {
        $row = mysqli_fetch_assoc($result_edit);
        $name = $row['name'];
        $phone = $row['phone'];
    }
}

//new btn
if(isset($_POST['new'])){
    header("location: index.php");
}

//update btn
if (isset($_POST['update'])) {
    unset($_SESSION['sid']);

    $id = $_POST['id'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];

    $mysqli->query("UPDATE data SET name='$name', phone='$phone' WHERE id=$id");

    $_SESSION['msg'] = "Number has been update";
    header('location: index.php');
}

//search btn
if (isset($_POST['search'])) {
    unset($_SESSION['sid']);

    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $result_search = $mysqli->query("SELECT * FROM data WHERE phone='$phone' OR name='$name'");

    $row_search = mysqli_fetch_assoc($result_search);
    foreach ($result_search as $sid) {
        $tr[] = $sid;
    }

    if(count($tr) > 0){
        $_SESSION['sid'] = $tr;
        $_SESSION['msg'] = "Search completed successfully!";
    }else{
        $_SESSION['msg'] = "The search was completed without result... =(";
    }

    header('location: index.php');
}