# URL Shortener

A **URL shortening service** with API endpoints and usage statistics.

---

## Table of Contents

- [Installation](#installation)
- [Configuration](#configuration)
- [Maintenance](#maintenance)
- [Usage Examples](#usage-examples)
- [Architecture Decisions](#architecture-decisions)

---

## Installation

1. Install dependencies:

```bash
composer install
```

2. Create the queue table:

```bash
php artisan queue:table
php artisan migrate
```

---

## Configuration

Edit your `.env` file:

```dotenv
APP_URL=http://url-shortener.test
API_KEY=your-secret-api-key
DB_DATABASE=your_database
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password
```

---

## Maintenance

- Run the queue worker for asynchronous jobs:

```bash
php artisan queue:work
```

- Run all **Feature** and **Unit** tests:

```bash
php artisan test
```

---

## Usage Examples

### 1. Redirect a short link (GET)

```bash
curl --location --request GET 'http://url-shortener.test/r/y-net' \
--header 'Accept: application/json' \
--header 'Content-Type: application/json' \
--header 'X-Api-Key: shortener-Secret!'
```

---

### 2. Create a new short link (POST)

```bash
curl --location --request POST 'http://url-shortener.test/api/links' \
--header 'Accept: application/json' \
--header 'Content-Type: application/json' \
--header 'X-Api-Key: shortener-Secret!' \
--data '{
  "target_url": "http://film-planets.com/",
  "slug": "star-xyz"
}'
```

---

### 3. Update link availability (PATCH)

```bash
curl --location --request PATCH 'http://url-shortener.test/api/links/star-wars' \
--header 'Accept: application/json' \
--header 'Content-Type: application/json' \
--header 'X-Api-Key: shortener-Secret!' \
--data '{
  "is_active": false
}'
```

---

### 4. Get link statistics (GET)

```bash
curl --location --request GET 'http://url-shortener.test/api/links/star-wars/stats' \
--header 'Accept: application/json' \
--header 'Content-Type: application/json' \
--header 'X-Api-Key: shortener-Secret!'
```

---

## Architecture Decisions

- **API Key Authentication Middleware**  
  Created `ApiKeyAuth` middleware for generic authentication on create/update requests — no need to repeat `authorize()` in each FormRequest.

- **Separate Web and API Routes**  
  Simplifies maintenance and allows different behaviors for redirects vs API endpoints.

- **Caching Slug Stats**  
  Reduces unnecessary database load by caching statistics per slug.

- **Queue for Logging Hits**  
  `LogLinkHit` jobs are dispatched asynchronously to improve performance and responsiveness.
