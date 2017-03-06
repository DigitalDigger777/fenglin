make auth url in controller    

```$wechatService = $this->get('wechat');```  
```$wechatService->buildAuthUrl('snsapi_userinfo', 123);```

get urls
```http://dev./panda-we-chat/get-url/code