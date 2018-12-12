### Hotspot Wifi - B2B Project.

####Installation Instructions
1. Run git clone ...
2. Create a MySQL database for the project
3. Create database and set it to .env
4. From the projects root run cp .env.example .env
5. Configure your .env file
6. Run composer update from the projects root folder
7. From the projects root folder run php artisan key:generate
8. From the projects root folder run php artisan migrate
9. From the projects root folder run composer dump-autoload
10. From the projects root folder run php artisan db:seed
11. npm run dev
