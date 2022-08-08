<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About SUPERVISIOR

Supervisor is basically linux based daemon that runs in the background. We have to configure our laravel app so that supervisor know about background jobs. Make sure in above file to change the location of your project directory by replacing /var/www/app.com and to replace user with your linux logged in user id.

Supervisor is mainly for running queue without any artisan command and we can view logs in the code

## Steps for installation Supervisor    

- First step is to use this command "sudo apt-get install supervisor"
- Move to conf.d directory by using "cd /etc/supervisor/conf.d"
- Create a  new file in the directory "laravel-worker.conf" with ".conf" extension
- Fill the following code in the file you created
    [program:laravel-worker]
        process_name=%(program_name)s_%(process_num)02d
        command=php /("path of your project")/artisan queue:work  --sleep=3 --tries=3 --max-time=3600
        autostart=true
        autorestart=true
        stopasgroup=true
        killasgroup=true
        user=forge  --> ("is your local username")
        numprocs=8
        redirect_stderr=true
        stdout_logfile=/home/("path location for where this supervisor log need to be stored in your project")/worker.log
        stopwaitsecs=3600

-  Use the following three codes to start supervisor and if it correct it shows :
-   sudo supervisorctl reread --> shows ("laravel-worker: changed")
-   sudo supervisorctl update --> shows ("laravel-worker: updated process group")
-   sudo supervisorctl start laravel-worker:* 
        -->shows ("laravel-worker:laravel-worker_02: started")

## Other Command for Supervisor

- sudo service supervisor stop

- sudo service supervisor start

- sudo supervisorctl restart all

- sudo service supervisor status




### Blog Refered

Use this blog --|

- **[Laravel documentation](https://laravel.com/docs/9.x/queues#supervisor-configuration/)**


## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct


- Laravel Accessors and Mutators are custom, user defined methods used in this project.
- Accessors and Mutators are used in the model.
- Accessor syntax is [getParamAttribute]() while for  Mutators [setParamAttribute]()
- Accessors is to get the value from db and show that value in the user's need.
- Mutators is to set the value in db and store 
## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
