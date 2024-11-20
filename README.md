# Product Parser

## Table of Contents

- [About](#about)
- [Installing](#installing)
- [Usage](#usage)

## About <a name = "about"></a>

Product parser which scrapes products from Ebay store and saves data to database and csv file asynchronously.

### Installing <a name = "installing"></a>

```bash
# Build docker containers
docker-compose build
# Run docker containers 
docker compose up -d
# Copy .env.example to .env
cp .env.example .env 
# Generate APP_SECRET
make generate-secret 
# Install dependencies
make ci
# Create migration file
make make-migration 
# Run migrations
make migrate 
```

## Usage <a name = "usage"></a>

### Run Scraper
```bash
# Run RabbitMQ message consumer
make consume-messages 
# Scrape electronics category (first 3 pages)
make scrape-category type=ebay category=electronics pages=3 
```
