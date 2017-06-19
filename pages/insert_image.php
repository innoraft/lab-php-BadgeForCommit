<?php
session_start();
$configs = include('../config/config.php');
$db =mysqli_connect("$configs->host","$configs->username","$configs->pass","$configs->database");

if($_POST) {
 $valid = array('success' => false, 'messages' => array());
 
    $name = $_POST['fullName'];
    $desc = $_POST['desc'];
 
    $type = explode('.', $_FILES['userImage']['name']);
    $type = $type[count($type) - 1];
    $url = '../assets/images/' . uniqid(rand()) . '.' . $type;
 
    if(in_array($type, array('gif', 'jpg', 'jpeg', 'png'))) {
        if(is_uploaded_file($_FILES['userImage']['tmp_name'])) {
            if(move_uploaded_file($_FILES['userImage']['tmp_name'], $url)) {
 
                // insert into database
                $sql = "INSERT t_badge (badge_name, badge_icon,badge_desc,badge_author) VALUES ('$name', '$url','$desc','".$_SESSION['user']."')";
 
                if($db->query($sql) === TRUE) {
                    $valid['success'] = true;
                    $valid['messages'] = "Successfully Uploaded";
                } 
                else {
                    $valid['success'] = false;
                    $valid['messages'] = "Error while uploading";
                }
 
                $db->close();
 
            }
            else {
                $valid['success'] = false;
                $valid['messages'] = "Error while uploading";
            }
        }
    }
 
    echo json_encode($valid);
 
    // upload the file 
}




 ?>
