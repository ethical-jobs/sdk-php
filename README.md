## Deprecation warning

All current EJ packages will be taken offline by mid-2021 in order to re-released under a single package.

## Compatibility

 - `v8.*` - Laravel 8 or higher, PHP >8.x,<9.x
 - `v4.*` - Laravel 8 or higher, PHP 7.3
 - `v3.*` - Laravel 7 or lower (possibly only 5.6 to 5.9)

## Installation

`composer require ethical-jobs/@ethical-jobs/sdk`

For Laravel < `5.5.x` include the service provider and facade in you `config/app.php` file `EthicalJobs\SDK\Laravel\ServiceProvider::class`, `'EthicalJobs' => EthicalJobs\SDK\Laravel\ApiFacade::class,`. For Laravel >= `5.5.x` the package will auto-include the service provider and facade.

## Authentication

You will need to set 4 environment variables to enable authentication:

```json
{
    "AUTH_CLIENT_ID": "The client id of the oauth grant",
    "AUTH_CLIENT_SECRET": "The client secret of the oauth grant",
    "AUTH_SERVICE_USERNAME": "Username or email of the user",
    "AUTH_SERVICE_PASSWORD": "Base64 encoded password of the user",
}
```

When using an endpoint that requires authentication you first need to call `EthicalJobs::authenticate()`.

## Making Requests

There are many ways to access api resources, following are some examples:

```php
// GET /jobs
EthicalJobs::get('/jobs', ['status' => 'APPROVED']);

// GET /jobs/drafts
EthicalJobs::get('/jobs/drafts', ['status' => 'APPROVED']);

// GET /jobs/214
EthicalJobs::get('/jobs/214');

// GET /jobs { status: APPROVED, expired: false }
EthicalJobs::resource('jobs')->approved();

// GET /jobs { expired: true }
EthicalJobs::resource('jobs')->expired();

// POST /jobs { ... }
EthicalJobs::post('/jobs', ['title' => 'React Developer', 'description' => 'We are looking for...']);
```

## Responses

Responses are returned as `EthicalJobs\SDK\Collection` that extends `Illuminate\Support\Collection`. If there are no results an empty collection is returned. This class has extended methods for selecting nested response items: `$collection->entities('jobs');`. Also there are 

## Testing and mocking

For easy mocking of SDK responses there exists a response stack helper function on the `ApiClient` or `EthicalJobs` facade. This returns a fully mocked instance of the `ApiClient` that you may inject into the Laravel IOC container or use directly.

For mocking actual SDK responses there are also up-to-date mock JSON responses accessible within `EthicalJobs\SDK\Testing\ResponseFactory`.

```php
// Mocking a set of api calls and their responses
$api = ApiClient::mock([
    ResponseFactory::response(204, ResponseFactory::jobs()),
    ResponseFactory::response(201, ResponseFactory::job()),
    ResponseFactory::response(200, ResponseFactory::user()),
]);

// Subsequent calls will return the above responses in order
$jobs = $api->get('/jobs');
$job = $api->get('/job/17263');
$user = $api->get('/user/2827');
```
