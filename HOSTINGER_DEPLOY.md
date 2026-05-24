# Hostinger Deploy Notes

## Runtime

- PHP version: 8.2 or newer. PHP 8.2 is the safest Hostinger setting for this Laravel 12 build.
- Web root / public folder: repository root. The root `index.php` boots the Laravel app from `tiamcp-web/`.
- Do not commit `.env` files. Create the production `.env` on Hostinger at `tiamcp-web/.env`.

## Production `.env`

Copy `tiamcp-web/.env.example` to `tiamcp-web/.env` on the server, then set these values from Hostinger hPanel:

```dotenv
APP_KEY=base64:GENERATE_WITH_ARTISAN_KEY_GENERATE
APP_URL=https://tiamcp.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=HOSTINGER_DATABASE_NAME
DB_USERNAME=HOSTINGER_DATABASE_USER
DB_PASSWORD=ROTATED_HOSTINGER_DATABASE_PASSWORD

ENTITLEMENT_SIGNING_KEY_ID=hostinger-production
ENTITLEMENT_SIGNING_ALG=HS256
ENTITLEMENT_SIGNING_SECRET=base64:GENERATE_A_RANDOM_SIGNING_SECRET
```

Hostinger database names and usernames are usually prefixed. Use the exact full values shown in hPanel, not shortened local names.
For this shared-hosting deployment, HS256 is used so no private key file has to be stored on the server.

## First Deploy Commands

Run these once after the `.env` file exists on Hostinger:

```bash
php artisan key:generate --force
php artisan migrate --force
php artisan db:seed --class=PlanSeeder --force
php artisan db:seed --class=EntitlementSeeder --force
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

If Hostinger Git deploy does not run Composer, keep the committed `vendor/` directory in this repository.
