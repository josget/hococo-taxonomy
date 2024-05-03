<p align="center"><a href="https://www.hococo.io" target="_blank"><img src="https://assets-global.website-files.com/620673c3bbc8c1b99ec8ff01/6206b65ff32a5f278059d71d_hococo_logo.svg" width="400" alt="Laravel Logo"></a></p>

Hococo Taxonomy
====

## Prerequisites

- Docker Desktop installed on your machine
- MacOS or Linux

## 1. Clone the repository
```bash
git clone https://github.com/josget/hococo-taxonomy.git
cd hococo-taxonomy
```

## 2. Install dependencies
```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
```

## 3. Setup environment variables
```bash
cp .env.example .env
```

## 4. Startup
```bash
./vendor/bin/sail up -d
```

## 5. Run migration
```bash
./vendor/bin/sail artisan migrate
```

## 6. Run seeder
```bash
./vendor/bin/sail artisan db:seed
```

## 7. Build frontend
```bash
# Install Node.js dependencies
./vendor/bin/sail npm install

# Build the assets using your defined scripts in package.json
./vendor/bin/sail npm run build

```

## 8. Visit simple UI
```bash
http://localhost:9000
```

## 9. Visit api documentation
```bash
http://localhost:9000/docs/api
```