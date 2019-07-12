<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
date_default_timezone_set('PRC');

include "constants.php";
include "file_util.php";

//include 'file_util.php';

//$file_name = "TUZI_ALL";
//$file_path = "upload_file/TUZI_ALL.json";
//$add_date = NULL;
//$ower = "TUZI";


//$fu = new fileUtil;
//$fu->processUploadFile($file_name, $file_path, $add_date, $ower);

$type = $_GET['type'];
$ower = $_GET['ower'];


echo "当前用户：". $ower."<br/>";


if($type == "base"){
    $file_name_base = $_GET['file_name_base'];
    $file_path_base = UPLOAD_PATH_BASE;

    $file_type_base = substr($file_name_base, 0, strpos($file_name_base, '.'));
    $file_path_base = $file_path_base.$file_name_base;
    $add_date_base = NULL;
    $fu = new fileUtil;
    if(!empty($file_type_base)){
        $fu->processUploadFile($file_type_base, $file_path_base, $add_date_base, "BASE");
        echo "文件：". $file_name_base." 处理完成 <br/>";

    }



}

if($type == "main"){
    $file_name_all = $_GET['file_name_all'];
    $file_path_all = UPLOAD_PATH_ALL;
    $file_name_new = $_GET['file_name_new'];
    $file_path_new = UPLOAD_PATH_NEW;

    $ower = $_GET['ower'];

    $file_type_all = substr($file_name_all, 0, strpos($file_name_all, '.'));
    $file_path_all = $file_path_all.$file_name_all;
    $add_date_all = NULL;

    $file_type_new = substr($file_name_new, 0, strpos($file_name_new, '.'));
    $file_path_new = $file_path_new.$file_name_new;
    $add_date_new = NULL;

    $fu = new fileUtil;

    if(!empty($file_type_all)){
        $fu->processUploadFile($file_type_all, $file_path_all, $add_date_all, $ower);
        echo "文件：". $file_name_all." 处理完成 <br/>";
    }

    if(!empty($file_type_new)){
        $fu->processUploadFile($file_type_new, $file_path_new, $add_date_new, $ower);
        echo "文件：". $file_name_new." 处理完成 <br/>";
    }

    $file_name_delete = $ower."_DELETE_".date("Ymd").".json";
    $file_path_delete = DOWNLOAD_PATH_DELETE;


    if(!empty($file_type_all) && !empty($file_type_new)){
        $fu->createDeleteFile($file_name_delete, $file_path_delete, $file_type_all, $file_type_new);
        $fu->deleteWeixinItemByOwer($ower);

        echo "目标文件：". $file_name_delete." 创建完成 <br/>";

        setcookie("fileNameDelete", $file_name_delete, time()+3600);
    }

}