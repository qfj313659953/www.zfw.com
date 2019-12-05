<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="page-container">
        <p class="f-20 text-success">恭喜{{ $info['user'] }}登录成功！</p>
        <p>您登录的IP：{{ $info['ip'] }} 登录时间：{{ $info['time'] }}</p>
    </div>

</body>
</html>
