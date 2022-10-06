## Laravel File Reader

- Simple Laravel application to read text file page per page
- simple auth without database connection
- unit test
### Requirement with docker
- docker

### Requirement without docker

- php version >= 8.0.2

### Install with docker
- clone or extract project 
- go to the project folder
- cp .env.example .env
- docker-compose up -d (if you have problem with port change APP_port value in .env file )
- docker exec -it file-reader-laravel-9_reader.file_1 composer install
- docker exec -it file-reader-laravel-9_reader.file_1 php artisan key:generate
- docker exec -it file-reader-laravel-9_reader.file_1 chown -R sail:sail
- docker exec -it file-reader-laravel-9_reader.file_1 php artisan test
- visit http://localhost:9000 (9000 is APP_port value in .env file)

### Install without docker
- clone or extract project 
- go to the project folder
- cp .env.example .env
- composer install
- php artisan key:generate
- chmod 777 -R storage
- php artisan serve
- php artisan test
- visit http://localhost:8000

###usage in docker environment
- use /var/www/html/public/index.php for test normal file  
- use /var/www/html/storage/logs/laravel.log for test normal file  
- use /var/www/html/public/logs/test_big_laravel.log for test high file

###notes
- public/index.php && test_big_laravel.log files is used in unit test so change on them maybe broke the test
doc
###screenshots
- in screenshots folder  
- Unit test 
- ![Alt text](screenshots/unit_test.png?raw=true "Unit test")
- First Page normal file  (/var/www/html/public/index.php)
- ![Alt text](screenshots/first_page.png?raw=true "Unit test")

- Middle Page normal file (/var/www/html/public/index.php)
- ![Alt text](screenshots/middle_page.png?raw=true "Unit test")

- Last Page normal file  (/var/www/html/public/index.php)
- ![Alt text](screenshots/last_page.png?raw=true "Unit test")

- First Page high file   (/var/www/html/public/test_big_laravel.log)
- ![Alt text](screenshots/100M_file_first_page.png?raw=true "Unit test")

- Last Page high file    (/var/www/html/public/test_big_laravel.log)
- ![Alt text](screenshots/100M_file_last_page.png?raw=true "Unit test")
