## Installation
- run `composer install && npm install && npm run production`
- run `cp .env.example .env` and edit config details
- run `php artisan key:generate` and `php artisan jwt:secret`
- run `php artisan migrate --seed`
- run `php artisan serve --port=8080` or host it on your own dev server

## Usage

#### Development

```bash
# build and watch
npm run watch

# serve with hot reloading
npm run hot
```

#### Production

```bash
npm run production
```