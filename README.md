# crucis_backend
Это MVP проект сайта-блога разработанный за 6 дней во время проведения хаккатона в TSPK. Проект полностью построен на Laravel. Использован стиль RESTful API. Так же проект содержит в себе полностью автоматически сгенерированную документацию. Она находится на маршруте `/docs/api` и алиасе `/`.

## Цель
MVP платформа для блога с функциональностью:

* Главная страница (Лента блога)
    * Список недавних постов
    * Возможность фильтрации по времени
    * Кнопка "Читать далее"
* Страница создания поста с:
    * Отображением полного текста
    * Возможностью комментирования
    * Ссылками на социальные сети
* Страница пользователя (личный кабинет) с возможностью:
    * Регистрации с электронной почтой и паролем
    * Входа после регистрации
    * Редактирования личной информации и постов
    * Просмотра личной информации
* Административная панель с возможностями:
    * Входа
    * Просмотра и модерации пользователей, постов и комментариев
 
## Результат
Все цели были достигнуты, этот хаккатон для меня точно удался. Страница входа в административную панель была заменена системой ролей. Frontend успели реализовать на React. Единственное замечание - нет собственной вёрстки, были использованы Material UI компоненты. Это позволило сильно сократить время на дизайн и вёрстку.

Репозиторий с Frontend: https://github.com/srgyCheese/crucis_frontend  
  
Скриншот документации:
![image](https://github.com/Receiver1/crucis_backend/assets/62743649/a673e6b5-42bd-4f58-9217-3f2e277428fc)

Скриншот главной страницы:
![image](https://github.com/Receiver1/crucis_backend/assets/62743649/6a9527bf-ded6-40e0-b360-bb81b9d75ff3)
