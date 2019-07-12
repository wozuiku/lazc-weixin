<?php
/**
 * Created by PhpStorm.
 * User: xianxiaoge
 * Date: 2019-06-20
 * Time: 18:10
 */

include 'db_util.php';


class fileUtil
{

    function processUploadFile($fileType, $filePath, $addDate, $ower){


        $weixin_file = fopen($filePath, "r") or die("无法打以下文件：".$filePath);

        $file_content = fread($weixin_file, filesize($filePath));

        $file_content_substr = substr($file_content, 4, count($file_content) - 4);

        $weixin_array = explode('},', $file_content_substr);

        $array_len=count($weixin_array);

        $du = new dbUtil;
        $du->getConn();

        for ($i = 0; $i < $array_len; $i++) {
			if($i == $array_len - 1){
                $weixin_array_new[$i] = $weixin_array[$i];

            }else{
                $weixin_array_new[$i] = $weixin_array[$i] . '}';
            }
			
            $weixin_json_item = json_decode($weixin_array_new[$i], true);

            if($du->checkWeixinItemByOwerTypeWxid(@$ower, $fileType, $weixin_json_item["wxid"]) == "N"){

                $du->insertWeixinItem($fileType, $weixin_array_new[$i], $weixin_json_item["wxid"], $addDate, $ower);

            }


        }
        $du->disConn();

        fclose($weixin_file);

    }


    function createDeleteFile($fileName, $filePath, $typeAll, $typeNew){


        $du = new dbUtil;
        $du->getConn();
        $weixin_item_target = $du->queryTargetWeixinItem($typeAll, $typeNew);
        $du->disConn();

        //print_r($weixin_item_target);

        $delete_file_content = "[";

        $count_target = count($weixin_item_target);
        for ($i = 0; $i < $count_target; $i++) {
            //echo $weixin_item_target[$i];
            $delete_file_content = $delete_file_content.$weixin_item_target[$i].",";

        }

        //$file_content_delete = $file_content_delete."]";
        $delete_file_content = substr($delete_file_content, 0, - 1).PHP_EOL."]";;



        $delete_file_name = $filePath.$fileName;

        //echo $delete_file_name;

        //echo $delete_file_content;

        $delete_file = fopen($delete_file_name, "w") or die("无法打开文件：".$delete_file_name);
        fwrite($delete_file, $delete_file_content);
        fclose($delete_file);

    }

    function deleteWeixinItemByOwer($ower){

        $du = new dbUtil;
        $du->getConn();
        $du->deleteWeixinItemByOwer($ower);
        $du->disConn();

    }

}





//$now_time= time();
//$now_date= date('ymdhis',$now_time);//2018-11-28 15:29:29

//echo $now_date;

/*$file_type_new = "RUOYI_NEW";
$file_path_new = "/Users/xianxiaoge/file/upload/new/RUOYI_NEW.json";
$add_date_new = NULL;
$ower = "RUOYI";

$fu = new fileUtil;
//$fu->processUploadFile($file_type_all, $file_path_all, $add_date_all, $ower);
$fu->processUploadFile($file_type_new, $file_type_new, $file_path_new, $ower);*/




