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

    '/showtimes'         => ['controller' => 'ShowtimeController', 'method' => 'getAllShowtimes'],
    '/add_showtime'         => ['controller' => 'ShowtimeController', 'method' => 'addShowtime'],
    '/delete_showtime'         => ['controller' => 'ShowtimeController', 'method' => 'deleteShowtime'],
    '/find_showtimes_by_movie_and_auditorium'         => ['controller' => 'ShowtimeController', 'method' => 'findShowtimesByMovieAndAuditorium'],
    '/find_showtimes_by_date_and_time'         => ['controller' => 'ShowtimeController', 'method' => 'findShowtimeByDateAndTime'],

    '/bookings'         => ['controller' => 'BookingController', 'method' => 'getAllBookings'],
    '/add_booking'         => ['controller' => 'BookingController', 'method' => 'addBooking'],

    '/seats'         => ['controller' => 'SeatController', 'method' => 'getAllSeats'],
    '/add_seat'         => ['controller' => 'SeatController', 'method' => 'addSeat'],
    
    



];