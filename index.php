<html>
<head>
    <meta charset="utf-8">
    <title>微信防封</title>
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
            margin-left: -120px;
            font-size: 50px


        }

    </style>
</head>
<body onload="checkUser()">

<a class="base" href="base.php" >基础数据维护</a>
<a class="logout" href="login.php" onclick="logout()">退出</a>

<div class="div-center">

    <div class="file-box">
        <label class="title">微信防封</label>
    </div>


    <div class="file-box">
        <label>全部微信:</label>
        <input type="text" id="textfieldAll" class="txt" placeholder="例子：TUZI_ALL.json"/>
        <input type="button" class="btn" value="浏览..."/>
        <input type="file" name="fileFieldAll" class="file" id="fileFieldAll"
               onchange="document.getElementById('textfieldAll').value=document.getElementById('fileFieldAll').files[0].name"/>
        <input type="button" class="btn" value="上传"
               onclick="uploadFile('fileFieldAll', document.getElementById('textfieldAll').value)"/>

    </div>

    <div class="file-box">
        <label>最近微信:</label>
        <input type="text" id="textfieldNew" class="txt" placeholder="例子：TUZI_20190601_20190615.json"/>
        <input type="button" class="btn" value="浏览..."/>
        <input type="file" name="fileFieldNew" class="file" id="fileFieldNew"
               onchange="document.getElementById('textfieldNew').value=document.getElementById('fileFieldNew').files[0].name"/>
        <input type="button" class="btn" value="上传"
               onclick="uploadFile('fileFieldNew', document.getElementById('textfieldNew').value)"/>

    </div>



    <div class="file-box">
        <input id="processButton" type="button" class="btn2" value="开始处理" onclick="startProcess(this)"/>
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
        //alert("fileId = "+fileId);
        //alert("fileName = "+fileName);
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
                document.cookie = "downloadFlag=Y";

            }
        }

        var ower = getCookie("username");
        var processApi = "http://www.puataxi.com/weixin/process.php?type=main&file_name_all=" + getCookie("fileNameAll") + "&file_name_new=" + getCookie("fileNameNew") + "&ower=" + ower;


        //alert("processFile fileNameAll = "+getCookie("fileNameAll"));
        xmlhttp.open("GET", processApi, true);
        xmlhttp.send();
    }

    function startProcess(obj) {
        //alert("fileNameAll = " + getCookie("fileNameAll") + "fileNameNew = " + getCookie("fileNameNew"));
        var processButtonValue = document.getElementById('processButton').value;

        if (processButtonValue == "开始处理") {
			document.cookie = "downloadFlag=" + "" + "; " + -1;
			var fileNameAll = document.getElementById('textfieldAll').value;
            var fileNameNew = document.getElementById('textfieldNew').value;
			
			
            if(fileNameAll.length > 0 && fileNameNew.length > 0){
				processAjax();
				obj.disabled = true;
				var time = 0;
				var x = setInterval(function () {
					time = time + 1000; //reduce each second
					obj.value = "请稍等...(" + (time / 1000) % 60 + ")";
					var downloadFlag = getCookie("downloadFlag");
					if (downloadFlag == "Y") {
						clearInterval(x);
						obj.value = "开始下载";
						obj.disabled = false;
					}
				}, 1000);
            }else{
				alert("请先上传 全部微信 和 最近微信！");
			}
            document.cookie = "fileNameAll=" + "" + "; " + -1;
            document.cookie = "fileNameNew=" + "" + "; " + -1;
            document.cookie = "fileNameBase=" + "" + "; " + -1;
            document.getElementById('textfieldAll').value = null;
            document.getElementById('textfieldNew').value = null;
            document.getElementById('textfieldBase').value = null;
            document.getElementById("processMessage").innerHTML = null;
        }

        if (processButtonValue == "开始下载") {
            window.location.href = "http://www.puataxi.com/weixin/download.php?filename=" + getCookie("fileNameDelete");
            //document.cookie = "downloadFlag=" + "" + "; " + -1;
        }

    }








</script>
</html>