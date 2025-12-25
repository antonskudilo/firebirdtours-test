# Laravel Currency Module

Test assignment: a module for storing and converting currencies in Laravel 12 using Docker.

---

## Assignment Description

You need to create a module for storing and converting currencies.  
The module should have a predefined list of currencies (either hardcoded or added via admin panel at the developer's discretion). Exchange rates should be fetched from [https://freecurrencyapi.com/](https://freecurrencyapi.com/) (API documentation: [https://freecurrencyapi.com/docs](https://freecurrencyapi.com/docs)) for all available currencies and stored in the database. Exchange rates should be updated once per day.  

The module should provide a service for converting prices from one currency to another (example usage: `$converter->convert(123, 'USD', 'RUB');`).  

Additionally, an admin page should display all stored exchange rates.  

For integration with [https://freecurrencyapi.com/](https://freecurrencyapi.com/), you **cannot use ready-made libraries for this site** (e.g., [https://github.com/everapihq/freecurrencyapi-php](https://github.com/everapihq/freecurrencyapi-php)). Integration should be implemented using Guzzle, cURL, `file_get_contents`, or any other HTTP/network request tool.  

You can use any PHP framework you prefer for implementing the currency converter.

---

## Technology Stack

- PHP 8.4 + Apache
- Laravel 12
- MariaDB 11
- Docker + Docker Compose
- Laravel Queues
- REST API

---

## Project Setup

The project is containerized. To start it, run from the project root:

```bash
docker compose up --build
```

On container startup, the following steps are automatically executed:

1. Install dependencies via Composer
2. Generate application key: `php artisan key:generate`
3. Run migrations and seeders: `php artisan migrate --seed`
4. Load current exchange rates: `php artisan currency:update-rates`
5. Start Apache web server (HTTP access)
6. Start Laravel queues in a separate container

---

## Service Access

- Public API endpoint:

```text
/api/v1/convert
```

Expected request parameters:

- `amount` — the amount to convert  
- `from` — source currency code  
- `to` — target currency code  

Response format:

```php
[
    'amount' => $responseDto->amount,
    'from' => $responseDto->from,
    'to' => $responseDto->to,
    'result' => $responseDto->result,
]
```

- Admin login credentials:

```text
login: admin
password: admin
```

- List of available currencies in the admin panel:

```text
/currencies
```

- Stored exchange rates in the admin panel:

```text
/currency-rates
```

- Swagger-generated API documentation is available at:

```text
/api/documentation
```

---
