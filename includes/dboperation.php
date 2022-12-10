<?php

use phpDocumentor\Reflection\DocBlock\Description;

class DbOperation
{
    private $con;
    function __construct()
    {
        require_once dirname(__FILE__) . '/dbconnect.php';
        $db = new DbConnect();
        $this->con = $db->connect();
    }


    function insert_Profile($name, $email,$image)
    {
    date_default_timezone_set("America/Los_Angeles");
               $time = date("ymd");
               $id = '_' . $time . '_' . microtime(true);
               $upload_path = "../images/$id.jpg";
               $upload = substr($upload_path, 3);
        $stmt=$this->con->prepare("INSERT INTO `ptest`(`name`, `email`,`image`) VALUES (?,?,?)");
        $stmt->bind_param("sss", $name, $email,$upload);
        if ($stmt->execute())
        {
        file_put_contents($upload_path, base64_decode($image));
            return PROFILE_CREATED;
        }
        return PROFILE_NOT_CREATED;
    }



    // function update_Profile($id,$name, $email,$image)
    // {
    // date_default_timezone_set("America/Los_Angeles");
    //            $time = date("ymd");
    //            $id = '_' . $time . '_' . microtime(true);
    //            $upload_path = "../images/$id.jpg";
    //            $upload = substr($upload_path, 3);
    //     $stmt=$this->con->prepare("UPDATE `ptest` SET `name`= ? ,`email`=?,`image`=? WHERE id = ?");
    //     $stmt->bind_param("sssi", $name, $email,$upload, $id);
    //     if ($stmt->execute())
    //     {
    //     file_put_contents($upload_path, base64_decode($image));
    //         return PROFILE_CREATED;
    //     }
    //     return PROFILE_NOT_CREATED;
    // }

    
// function update_Profile($id, $name, $email, $image)
// {
//     if (isset($image)) {
//         date_default_timezone_set("Asia/Karachi");
//         $time = date("ymd");
//         $id = $time . '_' . microtime(true);
//         $upload_path = "../images/$id.jpg";
//         $upload = substr($upload_path, 3);
//     } else
//         $upload_path = null;
//     $stmt = $this->con->prepare("UPDATE `ptest` SET `name`=?,`email`=?,`image`=?  WHERE `id`= ?");
//     $stmt->bind_param("sssi", $name, $email, $upload, $id);
//     if ($stmt->execute()) {
//         file_put_contents($upload_path, base64_decode($image));
//         return PROFILE_UPDATED;
//     }
//     return PROFILE_NOT_UPDATED;
// }


function update_profile($id, $name, $email, $image)
{
    if (isset($image)) {
        date_default_timezone_set("Asia/Karachi");
        $time = date("ymd");
        $iid = $time . '_' . microtime(true);
        $upload_path = "../images/$iid.jpg";
        $upload = substr($upload_path, 3);
    } else
        $upload_path = null;
    $stmt = $this->con->prepare("UPDATE `ptest` SET `name`=?,`email`=?,`image`=? WHERE `id`= ?");
    $stmt->bind_param("sssi", $name,$email, $upload, $id);
    if ($stmt->execute()) {
        file_put_contents($upload_path, base64_decode($image));
        return PROFILE_UPDATED;
    }
    return PROFILE_NOT_UPDATED;
}



    function get_Profile()
{
$stmt = $this->con->prepare ("SELECT * FROM `ptest`");
$stmt->execute();
$stmt->bind_result($id , $name, $email, $image);

  $cat = array();
         while ($stmt->fetch()) {
             $test = array();
             $imgurl =  'http://' .'localhost'.'/profile/' . $image;
$test['id'] = $id ;
$test['name'] = $name;
$test['email'] = $email ;
$test['image'] = $imgurl;
 array_push($cat, $test);
}
return $cat;
}


    // delete method
    function delete_Profile($id)
    {
        $stmt=$this->con->prepare("DELETE FROM `ptest`  WHERE id = (?)");
        $stmt->bind_param("i",$id);
        if($stmt->execute())
        {
            return PROFILE_CREATED;
        }
        return PROFILE_NOT_CREATED;
    }






}