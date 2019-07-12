<?php
/**
 * Created by PhpStorm.
 * User: xianxiaoge
 * Date: 2019-06-22
 * Time: 17:18
 */

include "constants.php";

class dbUtil
{

    var $servername = SERVERNAME;
    var $username = USERNAME;
    var $password = PASSWORD;
    var $dbname = DBNAME;

    var $conn;


    function getConn()
    {

        $this->conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    }


    function disConn()
    {

        $this->conn = null;

    }


    function createTable()
    {


    }


    function checkWeixinItem($wxid)
    {


        try {
            $sql = "select count(*) from weixin_item where wxid = :wxid";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':wxid', $wxid);
            $stmt->execute();
            $row = $stmt->fetch();

            if ($row[0] > 0) {

                return "Y";

            } else {
                return "N";
            }


            //echo "新记录插入成功";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }


    }

    function checkWeixinItemByOwerTypeWxid($ower, $type, $wxid)
    {


        try {
            $sql = "select count(*) from weixin_item where ower = :ower and type = :type and wxid = :wxid";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':ower', $ower);
            $stmt->bindParam(':type', $type);
            $stmt->bindParam(':wxid', $wxid);
            $stmt->execute();
            $row = $stmt->fetch();

            if ($row[0] > 0) {

                return "Y";

            } else {
                return "N";
            }


            //echo "新记录插入成功";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }


    }


    function insertWeixinItem($type, $weixin_item, $wxid, $add_date, $ower)
    {


        try {
            $sql = "INSERT INTO weixin_item (type, weixin_item, wxid, add_date, ower) 
    VALUES (:type, :weixin_item, :wxid, :add_date, :ower)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':type', $type);
            $stmt->bindParam(':weixin_item', $weixin_item);
            $stmt->bindParam(':wxid', $wxid);
            $stmt->bindParam(':add_date', $add_date);
            $stmt->bindParam(':ower', $ower);

            $stmt->execute();


            //echo "新记录插入成功";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }


    }


    function deleteWeixinItemByType($type)
    {

        try {
            $sql = "DELETE FROM weixin_item WHERE type = :type";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':type', $type);
            $stmt->execute();

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

    }

    function deleteWeixinItemByOwer($ower)
    {

        try {
            $sql = "DELETE FROM weixin_item WHERE ower = :ower";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':ower', $ower);
            $stmt->execute();

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

    }


    function queryWeixinItemByType($type)
    {

        $sql = "SELECT * FROM weixin_item wi WHERE wi.type = :type";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':type', $type);
        $stmt->execute();
        $i = 0;
        while ($row = $stmt->fetch()) {

            //print_r($row);

            $weixin_item[$i] = $row['weixin_item'];
            $i++;
        }

        //echo $i.PHP_EOL;

        return $weixin_item;


    }

    function queryWeixinItemByOwer($ower)
    {

        $sql = "SELECT * FROM weixin_item wi WHERE wi.ower = :ower";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':ower', $ower);
        $stmt->execute();
        $i = 0;
        while ($row = $stmt->fetch()) {

            //print_r($row);

            $weixin_item[$i] = $row['weixin_item'];
            $i++;
        }

        //echo $i.PHP_EOL;

        return $weixin_item;


    }



    function queryTargetItem($typeAll, $typeNew){

        $weixin_item_all = $this->queryWeixinItemByType($typeAll);
        $weixin_item_new = $this->queryWeixinItemByType($typeNew);
        $weixin_item_base = $this->queryWeixinItemByOwer("BASE");

        $count_all = count($weixin_item_all);
        $count_new=count($weixin_item_new);
        $count_base = count($weixin_item_base);


        $except_index = 0;
        for ($i = 0; $i < $count_new; $i++) {
            $weixin_item_except[$except_index] = $weixin_item_new[$i];
            $except_index++;
        }

        for ($i = 0; $i < $count_base; $i++) {
            $weixin_item_except[$except_index] = $weixin_item_base[$i];
            $except_index++;
        }

        $count_except = count($weixin_item_except);


        $target_index = 0;
        for($i = 0; $i < $count_all;  $i++){

            $exist_count = 0;
            $all_item = json_decode($weixin_item_all[$i], true);

            for($j = 0; $j < $count_except; $j ++){

                $except_item = json_decode($weixin_item_except[$j], true);

                if($all_item["wxid"] == $except_item["wxid"]){
                    $exist_count++;
                }
            }

            if($exist_count == 0){

                $weixin_item_target[$target_index] = $weixin_item_all[$i];
                $target_index++;

            }
        }

        //echo 'count_except = '.count($weixin_item_except).PHP_EOL;
        //echo 'count_target = '.count($weixin_item_target).PHP_EOL;

        //print_r($weixin_item_target);

        return $weixin_item_target;

    }
	
	function queryTargetWeixinItem($typeAll, $typeNew)
    {
        $sql = "SELECT *
                  FROM weixin_item wi
                 WHERE wi.type = :typeall
                   AND NOT EXISTS (SELECT '1'
                                     FROM weixin_item wi2
                                    WHERE wi2.wxid = wi.wxid
                                      AND wi2.type = :typenew)
                   AND NOT EXISTS (SELECT '1'
                                     FROM weixin_item wi3
                                    WHERE wi3.wxid = wi.wxid
                                      AND wi3.ower = 'BASE')";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':typeall', $typeAll);
        $stmt->bindParam(':typenew', $typeNew);
        $stmt->execute();
        $i = 0;
        while ($row = $stmt->fetch()) {

            //print_r($row);

            $weixin_item[$i] = $row['weixin_item'];
            $i++;
        }

        //echo $i.PHP_EOL;

        return $weixin_item;


    }
}









