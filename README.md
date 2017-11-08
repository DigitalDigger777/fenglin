fenglin
=======

compile js:  
grunt requirejs

login as consumer
=================
1. go to mysql and execute this query:
```sql
  select email, tel, role, api_key  from panda_users where role='ROLE_CONSUMER';
```
2. get some consumer and copy api_key
3. go to browser and make url, for example:
    http://dev.fenglin/app_dev.php/consumer?apikey=b8f94125206d51dcee647b42d0685581#consumer/home
    