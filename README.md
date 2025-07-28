# Laravel Semantic Search App

## Setup Instructions

1. Clone the repository:

git clone https://github.com/denish65/laravel-vector-search.git
cd laravel-vector-search


composer install
cp .env.example .env
php artisan key:generate


php artisan migrate

add your cohere ai COHERE_KEY key to env like this "COHERE_KEY=YOUr_COHERE_KEY"

php artisan import:categories

php artisan embeddings:generate

php artisan serve
