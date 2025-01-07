Question A:-
Open Terminal
1. Clone the repository
    git clone https://github.com/ashyong/card-game.git
    cd card-game

2. Install PHP dependencies
    composer install
        OR
    docker-compose exec app composer install

3. Copy environment file
    cp .env.example .env

4. Configure environment variables. Open `.env` file and update these settings:
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=card_game
    DB_USERNAME=your_username
    DB_PASSWORD=your_password

5. Generate application key
    php artisan key:generate
        OR
    docker-compose exec app php artisan key:generate  

6. Run database migrations
    php artisan migrate
        OR
    docker-compose exec app php artisan migrate

Running the Application
1. Start the Laravel development server
    php artisan serve

2. Open browser and navigate to http://localhost:8000/cards
3. Enter the number of people
4.Click "Distribute Cards" button


Question B:-
please review the file improvementSql.sql
