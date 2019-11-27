<?php

return [
    'appid' => 'wxb95d64ede8e5fb2f',
    'secret' => 'c92517779dee6dd4a6e68ae532f032a1',
    'url' => 'https://api.weixin.qq.com/sns/jscode2session?appid=%s&secret=%s&js_code=%s&grant_type=authorization_code',
    //分页
    'pagesize' => env('PAGESIZE',10)
];
