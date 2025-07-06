<?php 

$apis = [
    '/movies'         => ['controller' => 'MovieController', 'method' => 'getAllMovies'],
    '/add_movie'         => ['controller' => 'MovieController', 'method' => 'addMovie'],
    '/update_movie'         => ['controller' => 'MovieController', 'method' => 'updateMovie'],
    '/delete_movies'         => ['controller' => 'MovieController', 'method' => 'deleteMovies'],

    '/login'         => ['controller' => 'AuthController', 'method' => 'login'],
    '/register'         => ['controller' => 'AuthController', 'method' => 'register'],

    '/update_user'         => ['controller' => 'UserController', 'method' => 'updateUser'],
    '/delete_user'         => ['controller' => 'UserController', 'method' => 'deleteUser'],

    '/auditoriums'         => ['controller' => 'AuditoriumController', 'method' => 'getAllAuditoriums'],
    '/add_auditorium'         => ['controller' => 'AuditoriumController', 'method' => 'addAuditorium'],
    '/update_movie'         => ['controller' => 'AuditoriumController', 'method' => 'updateAuditorium'],

    

];