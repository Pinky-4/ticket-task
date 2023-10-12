# Ticket-Task

Install Node(18.14.2), NPM(9.5.0), PHP(8.2.10) for Project Basic Setup

Clone github

    git clone https://github.com/Pinky-4/ticket-task.git

Install dependency of project

    composer install

Install Node dependency using below commands
    
    npm i

Copy .env.example and create .env file
    
    sudo cp .env.example .env

Generate a new application key
    
    php artisan key:generate

Make database connection through env.

For update .env file using cmd use below command
    
    sudo nano .env

Set below varibale for database connection with your database

```DB_CONNECTION=mysql
DB_HOST=
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```



Migrate and seed database with table and predefined data

    php artisan migrate

In Terminal run below command for run project for Development Only

Fronted : ```npm run dev``` or ```npm run build```

Laravel : ```php artisan serve```
