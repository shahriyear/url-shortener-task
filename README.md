# Url Shortener [Laravel with Vue]  

Make your url short!  
### Installation
  
Database dump copy is in sql-dump folder.

Clone repository and install dependencies via composer and npm. 

```php
➜  git clone git@github.com:shahriyear/url-shortener-task.git

➜  cd url-shortener-task

➜  cp .env.example .env

➜  composer install

➜  npm install

➜  npm run dev

➜  php artisan key:gen

➜  php artisan serve

```
### Sate Browsing API Credentials

Put on .env

```
GOOGLE_SAFE_BROWSING_API_URL=https://safebrowsing.googleapis.com/v4/threatMatches:find
GOOGLE_SAFE_BROWSING_API_KEY=AIzaSyCCPppMBrYynSqOoR7A3fEqWl1VxwwXids

```