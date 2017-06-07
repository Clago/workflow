## PHP工作流

![image](https://github.com/Clago/workflow/raw/master/screenshots/1.jpg)

![image](https://github.com/Clago/workflow/raw/master/screenshots/2.jpg)

## 功能
- 1.绘制流程图
- 2.条件流转支持
- 3.子流程

## 使用
`cp .env.example .env`

`composer install`

导入数据库文件,文件地址：`database/sql/workflow_data.sql`

初始账号:
`1@qq.com 2@qq.com 3@qq.com 4@qq.com 5@qq.com 6@qq.com 7@qq.com 8@qq.com 9@qq.com 10@qq.com 密码统一为:123456`

邮件发送配置(qq为例)
```
MAIL_DRIVER=smtp
MAIL_HOST=smtp.qq.com
MAIL_PORT=465
MAIL_USERNAME=xxx@qq.com
MAIL_PASSWORD=zzzz(在QQ邮箱设置-账户-POP3/IMAP/SMTP/Exchange/CardDAV/CalDAV服务-生成授权码)
MAIL_FROM_ADDRESS=xxx@qq.com
MAIL_ENCRYPTION=ssl
```

## 感谢
[流程设计前端](https://github.com/payonesmile/flowdesign)