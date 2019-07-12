<html>
<head>
    <meta charset="utf-8">
    <title>用户登录</title>
    <style type="text/css">
        .div-center {
            width: 400px;
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
            width: 135px;
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

        .title {
            position: relative;
            left: 50%;
            margin-left: -200px;
            font-size:50px

        }
    </style>
</head>
<body>

<div class="div-center">
    <div class="file-box">

        <label class="title">用户登录</label>

    </div>
    <div class="file-box">
        <label class="txt2">助理:</label>
        <!--<input type="text" id="username" class="txt"/>-->
        <select id="username" class="txt">
            <option value="">请选择</option>
            <option value="TUZI">小兔子</option>
            <option value="RUOYI">若仪</option>
            <option value="CHENYA">晨雅</option>
            <option value="XIAOZHEN">小贞</option>
            <option value="ZHIYAO">之遥</option>
            <option value="YOUYOU">悠悠</option>
            <option value="XIAOXIAO">晓晓</option>
            <option value="JINGJING">静静</option>
            <option value="CHENCHEN">晨晨</option>
            <option value="ANRAN">安然</option>
            <option value="RUOXI">若溪</option>
            <option value="QIQI">琪琪</option>
        </select>
    </div>

    <div class="file-box">
        <label class="txt2">密码:</label>
        <input type="password" id="password" class="txt"/>
    </div>

    <div class="file-box">
        <input id="login" type="button" class="btn" value="登录" onclick="login()"/>
        <input id="reset" type="button" class="btn" value="重置" onclick="reset()"/>
    </div>
</div>


</body>
<script>

    function login() {

        var username = document.getElementById("username").value;
        var password = document.getElementById("password").value;

        if (username == "TUZI" && password == "Puataxi123") {
            document.cookie = "username=" + username;
            window.location.href = "index.php";
        }else if(username == "RUOYI" && password == "Puataxi123"){
            document.cookie = "username=" + username;
            window.location.href = "index.php";
        }else if (username == "CHENYA" && password == "Puataxi123") {
            document.cookie = "username=" + username;
            window.location.href = "index.php";
        } else {
            alert("用户名或者密码错误！！！");
        }
    }

    function reset() {

        document.getElementById('username').value = null;
        document.getElementById('password').value = null;

    }

</script>
</html>

