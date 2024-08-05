## Info
This is a simple example of REST API and Vue.js plus Vuex.
It does not have, full validation, full documentation, etc.
It can be improved and many things lacking, like entity validation, nelmio api doc(for SWAGGER), mysql indexes.
Also Organizers -> Events -> Tickets can be improved, if multiple organizers can have same event, or if Ticket has multiple events in it(Many to Many).
Frontend + Backend in one repo for simplicity, to not waste time to configure everything and dealing with CORS

Since this is a test task(not paid), I implemented minimum amount of stuff.

It has next:
1. REST API 
2. Vue + Vuex frontend - login/logout + simple CRUD
3. Authentication with JWT
4. API Authorization


## Usage

1. docker-compose up -d
2. docker exec -it app sh -c "./bin/console do:sc:dr --force && ./bin/console do:sc:cr && ./bin/console do:fi:lo --no-interaction"
3. docker-compose run --rm encore yarn build


## Access

1. 127.0.0.1:3000 - login username `test@gmail.com` password: `strange!`


## How to run tests

1. docker exec -it db sh -c "mysql -u user -ppassword -e 'create database symfony_test'"
2. docker exec -it app sh -c "./bin/console do:sc:dr --force -e test && ./bin/console do:sc:cr -e test"
3. docker exec -it app sh -c "./bin/console do:fi:lo -e test"
3. docker exec -it app sh -c "./bin/phpunit"


## Routes
```
www@2787e64996c8:/var/www$ ./bin/console debug:route
 --------------------------- ----------- -------- ------ -----------------------------
  Name                        Method      Scheme   Host   Path
 --------------------------- ----------- -------- ------ -----------------------------
  _preview_error              ANY         ANY      ANY    /_error/{code}.{_format}
  api_login_check             ANY         ANY      ANY    /api/login_check
  frontend                    ANY         ANY      ANY    /{vue}
  api_users_get               GET         ANY      ANY    /api/users/{id}
  api_user_edit_new           PUT|PATCH   ANY      ANY    /api/users/{id}
  api_events_get              GET         ANY      ANY    /api/events/{id}
  api_events_delete           DELETE      ANY      ANY    /api/events/{id}
  api_events_tickets_get      GET         ANY      ANY    /api/events/{id}/tickets
  api_organizers_get          GET         ANY      ANY    /api/organizers
  api_organizers_events_get   GET         ANY      ANY    /api/organizers/{id}/events
  api_tickets_get             GET         ANY      ANY    /api/tickets/{id}
  api_tickets_edit            PATCH       ANY      ANY    /api/tickets/{id}
  api_tickets_create          POST        ANY      ANY    /api/tickets
  api_tickets_delete          DELETE      ANY      ANY    /api/tickets/{id}
 --------------------------- ----------- -------- ------ -----------------------------
```
