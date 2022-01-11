<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>User Login</title>
    <link rel="stylesheet" type="text/css" href="{{asset('logins/css/login.css')}}" />
    <script src="https://cdn.bootcdn.net/ajax/libs/jquery/3.6.0/jquery.js"></script>
</head>
<body>
<div class="content">
    <div class="box">
        <div class="left">
            <img class="login-img" alt="Login" src="{{asset('logins/images/login.svg')}}" />
        </div>
        <div class="right">
            <h1 class="title">生活服务登录平台</h1>
            <div class="username">
                <label for="username">用户名</label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    autocomplete="off"
                    placeholder="账户名哟"
                />
            </div>
            <div class="password">
                <label for="password">密码</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    autocomplete="off"
                    placeholder="密码哟"
                />
            </div>

            <div id="errormessage"></div>
            <button class="submit">登录</button>
        </div>
    </div>
</div>
<script>
    //点击button按钮处理
    $(".submit").click(function(){
        $.post("/login",
            //发送给后端的数据
            {
                "username":$("#username").val(),
                "pwd":$("#password").val()
            },
            //回调函数
            function(data){
                var json=data;
                if(json.code == 9){
                    alert('用户名或密码错误');
                    $("#errormessage").text("用户名或密码错误");
                }
                else if(json.code== 1){
                    window.location.href=json.url;
                }
            }
        )
    })
</script>

</body>
</html>
