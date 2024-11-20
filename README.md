# Product Parser

## Table of Contents

- [About](#about)
- [Installing](#installing)
- [Usage](#usage)

## About <a name = "about"></a>

Product parser which scrapes products from Ebay store and saves data to database and csv file asynchronously.

### Installing <a name = "installing"></a>

```bash
docker compose up -d # Run docker containers 

cp .env.example .env # Copy .env.example to .env

make generate-secret # Generate APP_SECRET

make make-migration # Create migration file

make migrate # Run migrations
```

## Usage <a name = "usage"></a>

### Run Scraper
```bash
make consume-messages # Run RabbitMQ message consumer

make scrape-category type=ebay category=electronics pages=3 # Scrape electronics category (first 3 pages)
```
