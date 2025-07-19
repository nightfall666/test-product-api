# Product API (Laravel + MySQL)

REST API микросервис для управления товарами (CRUD), с авторизацией через Bearer токен.

---

## Стек

- **Laravel 11**
- **MySQL (через Docker)**
- **Sanctum** — аутентификация по токену
- **REST API** — JSON ответы с кодами ошибок

---

## Установка и запуск

### 1. Клонировать репозиторий

```bash
git clone git@github.com:nightfall666/test-product-api.git
cd test-product-api
```

---

### 2. Запустить БД через Docker

```bash
docker-compose up -d
```
---

### 3. Настроить `.env`

Создайте `.env`:

```bash
cp .env.example .env
```

Проверьте настройки подключения к БД:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=product_db
DB_USERNAME=root
DB_PASSWORD=root
```

---

### 4. Установить зависимости

```bash
composer install
```

---

### 5. Сгенерировать ключ и миграции

```bash
php artisan key:generate
php artisan migrate
```

---

### 6. Настроить Sanctum

```bash
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate
```

---

### 7. Запустить сервер

```bash
php artisan serve
```


