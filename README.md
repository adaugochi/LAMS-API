<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

## Generating Documentation
~~~
php artisan apidoc:generate
~~~

## Manually modifying the content of the generated documentation
~~~
php artisan apidoc:rebuild
~~~

## Running Heroku
~~~
heroku ps:exec
php artisan passport:keys
~~~

## Virtual Hosts
~~~
<VirtualHost *:80>
    ServerAdmin admin@example.com
    DocumentRoot "C:/wamp64/www/lams/public"
    ServerName local.lams.com
    <Directory C:/wamp64/www/lams/public>
       AllowOverride all
       Options -MultiViews
      #Require all granted
    </Directory>
</VirtualHost>
~~~