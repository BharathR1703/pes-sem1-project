<?php
    $names = json_decode($_POST['name'],true);
    $names_sr = serialize($names);
    print_r($names_sr);
    $conn = mysqli_connect("localhost","root","","test_db");

    if(!$conn){
        exit("connection Failed");
    }

    $sql = "UPDATE test_table SET test_col='$names_sr' WHERE id ='1'";
    $query = mysqli_query($conn,$sql); 
?>