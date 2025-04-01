## Api To-Do List


### Что бы запустить приложение, необходимо выполнить команды:


``` make init ``` Для сборки, настройки и запуска контейнеров для приложения

```make m-up ``` Для запуска миграций

``` make test``` Для запуска автотестов приложения


### После запуска приложения, будут доступны api методы на [localhost](http://localhost):

#### Создание задачи: `POST`  `/api/tasks`
#### Просмотр списка задач: `GET`  `/api/tasks`
#### Просмотр одной задачи: `GET` `/api/tasks/{id}`
#### Обновление (полное) задачи: `PUT`  `/api/tasks/{id}`
#### Обновление (частичное) задачи: `PATCH`  `/api/tasks/{id}`
#### Удаление задачи: `DELETE`  `/api/tasks/{id}`
