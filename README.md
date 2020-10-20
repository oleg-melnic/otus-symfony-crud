# otus-symfony-crud
1. Установка докер композ
2. в директории нашего проекта создаем папку project для будущего проекта и 2 - laradock для докер контейнеров
3. Скачиваем https://github.com/Laradock/laradock.git в laradock командой 
git clone https://github.com/Laradock/laradock.git ./laradock
4. Заходим в рабочий контейнер docker-compose exec workspace bash
5. Переключаем текущего пользователя su laradock
6. Настраиваем в контейнере гит
   git config --global user.email "you@example.com"
   git config --global user.name "Your Name"
7. curl -sS https://get.symfony.com/cli/installer | bash
8. (под рутом) mv /home/laradock/.symfony/bin/symfony /usr/local/bin/symfony
9. symfony new project --dir=/var/www
10. symfony composer req api

11. symfony server:start -d

12. symfony composer req debug --dev

13. Для лёгкой генерации контроллеров мы можем использовать пакет symfony/maker-bundle:
    symfony composer req maker --dev
    
14. symfony composer req annotations
15. Создаем контроллер
    symfony console make:controller HelloController
16. Для доктрины:
    composer require symfony/orm-pack
    composer require --dev symfony/maker-bundle

17. Создание DB php bin/console doctrine:database:create (.env)


Второе занятие

1. скачать https://github.com/oleg-melnic/otus-symfony-crud.git
2. bin/console make:entity
3. bin/console make:controller
