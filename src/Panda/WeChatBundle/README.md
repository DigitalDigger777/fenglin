make auth url in controller    

```$wechatService = $this->get('wechat');```  
```$wechatService->buildAuthUrl('snsapi_userinfo', 123);```