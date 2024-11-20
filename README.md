# Product Parser

## Table of Contents

- [About](#about)
- [Installing](#installing)
- [Usage](#usage)

## About <a name = "about"></a>

Product parser which scrapes products from Ebay store and saves data to database and csv file asynchronously.

### Installing <a name = "installing"></a>

Copy .env.example lines to .env, leave APP_SECRET

```bash
docker compose up -d
cp .env.example .env
make generate-secret
make make-migration
make migrate
```

## Usage <a name = "usage"></a>

### Run Scraper
```bash
# Run consumer 
make consume-messages
# Scrape electronics category (first 3 pages)
make scrape-category type=ebay category=electronics pages=3
```
