Made with PHP 8.2.0 and Laravel 10.8.0

## Installing

- Set up .env from example
- In the terminal run php artisan key:generate
- In the .env file set DB_CONNECTION=mysql
- In the .env file configure mailer settings
- In the terminal run php artisan migrate --seed
- In the terminal run php artisan queue:work

## Testing

- Add new post by sending POST request to /api/post with {website:..., title:..., description:...} where "website" matches existing title in the websites table
- Add new subscriber by sending POST request to /api/post with {website:..., email:...} where "website" matches existing title in the websites table
- Send emails by executing php artisan app:queue-emails
