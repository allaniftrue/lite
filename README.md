## Installation
- run `composer install && npm install`
- run `cp .env.example .env` and edit config details
- run `php artisan key:generate` and `php artisan jwt:secret`
- run `php artisan migrate`

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