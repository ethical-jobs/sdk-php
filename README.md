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

Authentication is made using `oauth2` and JWT tokens are returned and attached to headers as bearer tokens. The grant type is a `password` grant and thus its attached to a user model and thus the users access rights and roles.

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

Responses are returned as `Illuminate\Support\Collection`s if there are no results an empty collection is returned.

In the future the results will be returned from an extended `EthicalJobs\SDK\Collection` class with helper functions to select results from our normalized api responses.

`$collection->entities('jobs');`