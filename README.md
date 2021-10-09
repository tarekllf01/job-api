
## About API

These APIs are simple rest api for job apllication.

The api are listed bellow 

- [Register User](https://documenter.getpostman.com/view/6567060/UUy7c53V#3256e8bd-e4af-4ae2-adc5-94027f6360bc).
- [Login user](https://documenter.getpostman.com/view/6567060/UUy7c53V#c60dab53-a6e1-4bf3-8423-d9c7896896f1).
- [Logout](https://documenter.getpostman.com/view/6567060/UUy7c53V#ae0dd58a-7229-4338-9818-7d7bbffbe435).
- [View posts ](https://documenter.getpostman.com/view/6567060/UUy7c53V#24d8337c-0e3b-40f3-9a06-b8639e269c62).
- [View post details](https://documenter.getpostman.com/view/6567060/UUy7c53V#ac544056-2733-4d7f-9c8b-965f94572459).
- [Create Post](https://documenter.getpostman.com/view/6567060/UUy7c53V#54fc92d8-87f4-4c9c-8b95-71d5387aaf4d).
- [Update Post](https://documenter.getpostman.com/view/6567060/UUy7c53V#9c0acb57-0edf-4088-9603-5f3b0cafb6ad).
- [Delete Post](https://documenter.getpostman.com/view/6567060/UUy7c53V#c2a3fe6a-f7b0-45c2-82ac-120eea38bff7).
- [Create Admin user](https://documenter.getpostman.com/view/6567060/UUy7c53V#e28d7571-9b8e-484f-9734-8e9ddfcd1afb).

Checkout the API documentation page [Here] (https://documenter.getpostman.com/view/6567060/UUy7c53V)


## Installation Guide

Step 1: run the bellow command in your desired location where you want to setup the project
    git clone https://github.com/tarekllf01/job-api.git

Or your can simply download the poject.

Step 2: Go to project directiry open command / terminal and run the bellow command

    composer install    

Step 3: Run the bellow command 
    mv .env.example .env

    Open .env file and give database name, username & password.

Step 4: Run the bellow command 
    php artisan migrate
    Now all the database table should be created
    bellow users are also created.
        1.  ['name' => 'TAREK HOSSEN','email' => 'tarekllf01@gmail.com','role'=> 'admin','password'=>'password']
        2.  ['name' => 'TEST USER','email' => 'user@gmail.com','role'=> 'user','password'=>'password']

Step 5: Run the bellow command
    php artisan serve

Finally project has been installed in your system.
To consume the APIs pleae follow the [API documentation](https://documenter.getpostman.com/view/6567060/UUy7c53V)

## License
Open source. can be used without copy right for development & training purpose
