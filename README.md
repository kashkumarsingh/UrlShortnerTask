## Task
Create a URL shortening service where you enter a URL such as https://www.thisisalongdomain.com/with/some/parameters?and=here_too and it returns a short URL such as http://short.est/GeAi9K.

Tasks:

Two endpoints are required:

/encode - Encodes a URL to a shortened URL

/decode - Decodes a shortened URL to its original URL

Both endpoints should return JSON. There is no restriction on how your encode/decode algorithm should work. You just need to make sure that a URL can be encoded to a short URL and the short URL can be decoded to the original URL.

You do not need to persist short URLs if you don't need to you can keep them in memory. Provide detailed instructions on how to run your assignment in a separate markdown file or readme.


# URL Shortening Service

This project implements a simple URL shortening service using Laravel. 
The service allows users to encode a long URL into a shorter version and decode the shortened URL back to the original URL.

## Requirements

- PHP >= 8.1
- Composer
- Laravel 11.x
- A web server (Apache/Nginx) or built-in PHP server (xampp or wamp)
## Installation

Follow these steps to set up the URL shortening service on your local environment:

- Navigate into the project directory: cd urlshortnertask
- Install Composer (assuming comopser is already installed in the machine) Dependencies : composer install or you can use this command composer create-project --prefer-dist laravel/laravel urlshortnertask
- Environment Setup : Copy the .env.example file to create your .env file. This file contains the environment configuration for your Laravel application:cp .env.example .env
- Generate the application key:php artisan key:generate
- Running the Application: php artisan serve By default, the application will be accessible at http://localhost:8000.

## Create the Controller
- To create the controller for handling URL encoding and decoding, run the following command: php artisan make:controller UrlShortnerController
- This command will create a new controller file located at (app/Http/Controllers/UrlShortnerController.php). 
- You can then add the encoding and decoding logic to this controller.

## Define Routes
Open the routes file at routes/web.php  and add the following routes for your URL shortening service:
```use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UrlShortnerController;

Route::get('/', function () {
return response()->json(['message' => 'Welcome to the URL Shortener API']);
});

Route::post('/encode', [UrlShortnerController::class, 'encode']);
Route::post('/decode', [UrlShortnerController::class, 'decode']);

```
## API Endpoints

## Encode URL

- Endpoint: POST /encode
- Request : {
  "url": "https://www.thisisalongdomain.com/with/some/parameters?and=here_too"
  }
- Response should be something like this : {
  "short_url": "http://short.est/GeAi9K"
  }
- Validation : The url field is required and must be a valid URL


## Decode URL
- Endpoint: POST /decode
- Request: {
  "short_url": "http://short.est/GeAi9K"
  }
- Response should be something like this : {
  "original_url": "https://www.thisisalongdomain.com/with/some/parameters?and=here_too"
  }
- Validation : The short_url field is required and must be a valid URL.



## Running Tests
- Create a test file using following command : php artisan make:test UrlShortnerTest
- To run the tests for the application, execute the following command: php artisan test
- This will run all the feature and unit tests defined in the tests directory (look in project_directory/tests/Feature/UrlShortnerTest.php). Ensure all tests pass before submitting your assignment.


## Testing with Postman

- Step 1: Open Postman
- Step 2: Create a New Request
  - Click on the New button or select Request from the sidebar.
  - Name your request and choose a collection (optional).
  - Click Save.
- Step 3: Set Up Encode Request
  - Change the request type to POST.
  - Change the request type to POST.
  - Go to the Body tab and select raw. Choose JSON from the dropdown.
  - Enter the following JSON in the body:
  ```{
    "url": "https://www.thisisalongdomain.com/with/some/parameters?and=here_too"
    }
    ```
- Click Send. You should receive a response with a shortened URL.
- Step 4: Set Up Decode Request
  - Create another request.
  - Change the request type to POST.
  - Enter the URL: http://localhost:8000/decode.
  - In the Body tab, select raw and choose JSON.
  - Enter the following JSON in the body:
  ```
  { "short_url": "http://short.est/GeAi9K"}
    ```
- Click Send. You should receive a response with the original URL.


# Important Notes
- This implementation does not persist the URLs in a database; it stores them in memory.
## License
This project is open-source and available under the MIT License.