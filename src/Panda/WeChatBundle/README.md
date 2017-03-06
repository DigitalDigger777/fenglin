make auth url in controller    

```$wechatService = $this->get('wechat');```  
```$wechatService->buildAuthUrl('snsapi_userinfo', 123);```

get urls
```http://dev.fenglin/app_dev.php/panda-we-chat/get-url/code```   
```http://dev.fenglin/app_dev.php//panda-we-chat/get-url/qrconnect```  

update menu
```http://dev.fenglin/app_dev.php/panda-we-chat/custom-menu/create```  

    