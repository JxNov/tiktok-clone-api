# Setup Project

### Install composer dependencies

```bash
composer install
```

### Install NPM Dependencies (Optional, If any)

```bash
npm install
```

### Create a copy of your .env file

```bash
cp .env.example .env
```

### Generate an app encryption key

```bash
php artisan key:generate
```

### Create an empty database for our application

Create a database in your local machine and update the database credentials in .env file

### Add Laravel ui

```bash
composer require laravel/ui
```

### Migrate the database

```bash
php artisan migrate
```

### Seed the database (Optional, If any)

```bash
php artisan db:seed
```

### Link storage folder

```bash
php artisan storage:link
```

### Start the development server

```bash
php artisan serve
```

## Run vite dev server (Optional, If any)

```bash
npm run dev
```
