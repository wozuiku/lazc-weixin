<?php

include 'constants.php';



if ($_FILES["fileFieldAll"]["type"] == "application/json")
{
    if ($_FILES["fileFieldAll"]["error"] > 0) {
        echo "Return Code: " . $_FILES["fileAll"]["error"] . "<br />";
    } else {
        move_uploaded_file($_FILES["fileFieldAll"]["tmp_name"],
            UPLOAD_PATH_ALL . $_FILES["fileFieldAll"]["name"]);

        echo "文件：".$_FILES["fileFieldAll"]["name"]." 上传成功！";
    }


} elseif($_FILES["fileFieldNew"]["type"] == "application/json"){
    if ($_FILES["fileFieldNew"]["error"] > 0) {
        echo "Return Code: " . $_FILES["fileFieldNew"]["error"] . "<br />";
    } else {

        move_uploaded_file($_FILES["fileFieldNew"]["tmp_name"],
            UPLOAD_PATH_NEW . $_FILES["fileFieldNew"]["name"]);
        echo "文件：".$_FILES["fileFieldNew"]["name"]." 上传成功！";


    }

} elseif($_FILES["fileFieldBase"]["type"] == "application/json"){
    if ($_FILES["fileFieldBase"]["error"] > 0) {
        echo "Return Code: " . $_FILES["fileFieldBase"]["error"] . "<br />";
    } else {

        move_uploaded_file($_FILES["fileFieldBase"]["tmp_name"],
            UPLOAD_PATH_BASE . $_FILES["fileFieldBase"]["name"]);
        echo "文件：".$_FILES["fileFieldBase"]["name"]." 上传成功！";


    }

}


?>
