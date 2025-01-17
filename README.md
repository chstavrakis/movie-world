# Movie Word Application

## Summary

The Movie Word Application is a web-based platform that allows users to browse a list of movies, vote on them (like or hate), and view the overall voting results. The application is built using PHP and Laravel for the backend, and it includes features such as user authentication, movie management, and voting functionality.

## Features

- User authentication (login, registration, password confirmation)
- Movie management (list, create, update, delete)
- Voting system (like or hate movies)
- Display of voting results (likes and hates count)
- User-specific voting history

## Technologies Used

- PHP
- Laravel
- JavaScript
- Composer
- NPM

## Installation Instructions

### Prerequisites

Before you begin, ensure you have the following installed on your local machine:

- Docker Desktop

### Step-by-Step Installation

1. **Clone the Repository**

   ```sh
   git clone https://github.com/chstavrakis/movie-world.git
   cd movie-world
    ```
2. **Start the Docker Containers**

   ```sh
   docker-compose up -d
   ```

3. **Get inside web server**

   ```sh
   docker exec -it movies-web bash
   ```

4. **Install Composer Dependencies**

   ```sh
   composer install
   ```
5. **Run database migrations**

   ```sh
   php artisan migrate
   ```
6. **Open the Application in Your Browser**

   The application should now be running on `http://localhost:8002`.

## Testing Instructions

To run the tests for the application, use the following command:

```sh
php artisan test
```

### Code Quality Tools

#### PHP Code Sniffer

To run PHP Code Sniffer, use the following command:

```sh
php vendor/bin/phpcs
```

## Contact

If you have any questions or feedback, feel free to reach out to me at:
chstavrakis@hotmail.com
