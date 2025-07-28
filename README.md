# Laravel Semantic Search App

## Setup Instructions

1. Clone the repository:
```bash
git clone https://github.com/denish65/laravel-vector-search.git
cd laravel-vector-search


composer install
cp .env.example .env
php artisan key:generate


php artisan migrate


php artisan import:categories

php artisan embeddings:generate

php artisan serve
