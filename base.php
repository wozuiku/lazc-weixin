<html>
<head>
    <meta charset="utf-8">
    <title>基础数据维护</title>
    <style type="text/css">

        .div-center {
            width: 500px;
            margin: 0 auto;
        }

        .file-box {
            position: relative;
            width: 500px;
            margin: 20px;
        }

        .txt {
            height: 28px;
            line-height: 28px;
            border: 1px solid #cdcdcd;
            width: 235px;
        }

        .btn {
            width: 70px;
            color: #fff;
            background-color: #3598dc;
            border: 0 none;
            height: 28px;
            line-height: 16px !important;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #63bfff;
            color: #fff;
        }

        .btn2 {
            width: 460px;
            color: #fff;
            background-color: #3598dc;
            border: 0 none;
            height: 50px;
            line-height: 16px !important;
            cursor: pointer;
        }

        .file {
            position: absolute;
            top: 0;
            right: 85px;
            height: 30px;
            line-height: 30px;
            filter: alpha(opacity:0);
            opacity: 0;
            width: 254px
        }

        .base {
            position: absolute;
            top: 40px;
            right: 100px;

        }

        .logout {
            position: absolute;
            top: 40px;
            right: 40px;

        }

        .title {
            position: relative;
            left: 50%;
            margin-left: -140px;
            font-size: 50px


        }

    </style>
</head>
<body onload="checkUser()">

<a class="base" href="index.php" >微信防封</a>

<a class="logout" href="login.php" onclick="logout()">退出</a>

<div class="div-center">

    <div class="file-box">
        <label class="title">基础数据维护</label>
    </div>




    <div class="file-box">

        <label>基础数据:</label>
        <input type="text" id="textfieldBase" class="txt" placeholder="例子：LT_106.json"/>
        <input type="button" class="btn" value="浏览..."/>
        <input type="file" name="fileFieldBase" class="file" id="fileFieldBase"
               onchange="document.getElementById('textfieldBase').value=document.getElementById('fileFieldBase').files[0].name"/>
        <input type="button" class="btn" value="上传"
               onclick="uploadFile('fileFieldBase', document.getElementById('textfieldBase').value)"/>

    </div>


    <div class="file-box">
        <input id="processButton" type="button" class="btn2" value="开始处理" onclick="startProcess(this, 10000)"/>
    </div>


    <div id="processMessage" class="file-box">

    </div>


</div>


</body>
<script>

    function getCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i].trim();
            if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
        }
        return "";
    }

    function checkUser() {
        var username = getCookie("username");
        if (username == null || username == undefined || username == '') {
            window.location.href = "login.php";
        } else {
            //alert("username = " + username);
        }

    }

    function logout() {
        document.cookie = "username=" + "" + "; " + -1;
    }

    function uploadFile(fileId, fileName) {
        var index1 = fileName.lastIndexOf(".");
        var index2 = fileName.length;
        var fileType = fileName.substring(index1 + 1, index2);


        if (fileType != "json") {

            alert("请上传json格式文件");
            return;

        }

        //alert("fileId ="+fileId);

        if (fileId == "fileFieldAll") {

            document.cookie = "fileNameAll=" + document.getElementById('textfieldAll').value;

        } else if (fileId == "fileFieldNew") {

            document.cookie = "fileNameNew=" + document.getElementById('textfieldNew').value;

        } else if (fileId == "fileFieldBase") {

            document.cookie = "fileNameBase=" + document.getElementById('textfieldBase').value;

        }


        var xmlhttp;
        if (window.XMLHttpRequest) {
            //  IE7+, Firefox, Chrome, Opera, Safari 浏览器执行代码
            xmlhttp = new XMLHttpRequest();
        } else {
            // IE6, IE5 浏览器执行代码
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                var responseText = xmlhttp.responseText;
                document.getElementById("processMessage").innerHTML = responseText;


            }
        }


        var fileObj = document.getElementById(fileId).files[0]; // js 获取文件对象
        var form = new FormData(); // FormData 对象
        form.append(fileId, fileObj); // 文件对象


        var uploadApi = "http://www.puataxi.com/weixin/upload.php";


        //alert("processFile fileNameAll = "+getCookie("fileNameAll"));
        xmlhttp.open("POST", uploadApi, true);
        xmlhttp.send(form);


    }

    function processAjax() {
        var xmlhttp;
        if (window.XMLHttpRequest) {
            //  IE7+, Firefox, Chrome, Opera, Safari 浏览器执行代码
            xmlhttp = new XMLHttpRequest();
        } else {
            // IE6, IE5 浏览器执行代码
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            //alert("xmlhttp.readyState = "+xmlhttp.readyState+"xmlhttp.status = "+xmlhttp.status)
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                var responseText = xmlhttp.responseText;
                document.getElementById("processMessage").innerHTML = responseText;


            }
        }

        var ower = getCookie("username");
        var processApi = "http://www.puataxi.com/weixin/process.php?type=base" +  "&file_name_base=" + getCookie("fileNameBase") +  "&ower=" + ower;


        //alert("processFile file_name_base = "+getCookie("fileNameBase"));
        xmlhttp.open("GET", processApi, true);
        xmlhttp.send();
    }

    function startProcess(obj, time) {
        //alert("fileNameAll = " + getCookie("fileNameAll") + "fileNameNew = " + getCookie("fileNameNew"));

        processAjax();

    }


</script>
</html>