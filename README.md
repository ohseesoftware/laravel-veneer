# Laravel Veneer

A suite of fixture data and methods to help make mocking 3rd party services easier.

## Overview

Laravel Veneer aims to solve two problems for developers to assist with writing tests:

1. Provide static response data (fixtures) from 3rd party APIs
2. Provide SDK-specific abstractions on top of [Mockery](https://github.com/mockery/mockery) for mocking SDK calls

Both goals aim to help with 80% of the work needed for mocking/API responses, while leaving the remaining 20% up to the developer. As an example, Laravel Veneer will provide a generic mock and fixture for creating a new calendar via Cronofy, but if you need to test for a specific response, you'll need to mock that yourself.

### Fixtures

Fixtures are static _response_ data from 3rd party APIs such as Twitter, GitHub, Cronofy, etc. One goal of this package is to allow the community to contribute response fixtures for any available API.

### SDK Mocking

The SDK mocking layer is built specifically for Laravel, on top of Mockery. It allows developers to quickly mock various SDK calls for available 3rd party APIs, when using their SDK packages.

## Installation

Install the package via composer:

```
composer require ohseesoftware/laravel-veneer
```

There's no service provider or anything registered, all classes are used directly in your test classes.

## Usage

TODO:

## Contributing

The following sections will outline the guidelines for contributing new fixtures and SDK mocks.

### Contributing Fixtures

When adding fixtures, please try to adhere to the following guidelines. You can view the [existing fixtures](https://github.com/ohseesoftware/laravel-veneer/tree/master/fixtures) to see how they are structured.

#### Format

Currently, Laravel Veneer expects all fixtures to be defined in JSON. This may change in the future, but for the initial work, we want to focus on JSON endpoints.

#### Folder structure

The folder structure for fixtures is a little different depending on if the fixture is for a HTTP response or an incoming webhook payload.

For a HTTP response, the guideline is:

```
/fixtures/{name_of_service}/responses/{version?}/{path}/{method}.json
```

Where:

- `name_of_service` is the name of the service the fixture belongs to
- `version` is only required for `responses`, and should be set to the API's version, if applicable
- `path` is the path of the endpoint
- `method` is the HTTP method used to call the endpoint

As an example, here's the path for creating a new tweet using [Twitter's v2 API](https://developer.twitter.com/en/docs/twitter-api/tweets/manage-tweets/api-reference/post-tweets):

```
/fixtures/twitter/responses/v2/tweets/post.json
```

---

For webhook payload fixtures, the guideline is a bit simpler:

```
/fixtures/{name_of_service}/webhooks/{event}.json
```

Where:

- `name_of_service` is the name of the service the fixture belongs to
- `event` is the name of the event that triggered the webhook

As an example, here's the path for [Cronofy's `changeNotification` webhook payload](https://docs.cronofy.com/developers/api/push-notifications/#example-push-notification-request):

```
/fixtures/cronofy/webhooks/changeNotification.json
```

### Contributing SDK Mocks

For adding new SDK mocks, there's two pieces involved:

1. Adding a new class to present the class you are mocking, we call this a `MockProvider`
2. Adding a new class for the method you are mocking, we call this a `MockedMethod`

#### Adding a new `MockProvider`

The `MockProvider` usage is quite simple. All you need to do is extend the `MockProvider` class and then implement a method telling Laravel Veneer which class you are mocking:

```php
<?php

namespace OhSeeSoftware\LaravelVeneer\Providers\Cronofy;

use OhSeeSoftware\LaravelVeneer\Providers\MockProvider;

class CronofyMock extends MockProvider
{
    public function mockedClass(): string
    {
        return \Cronofy\Cronofy::class;
    }
}
```

#### Adding a new `MockedMethod`

Adding a new `MockedMethod` is also quite simple, but allows for more configuration. You'll need to create a new class that extends the `MockedMethod` class, and implement the required abstract methods:

```php
<?php

namespace OhSeeSoftware\LaravelVeneer\Providers\Cronofy\Channels;

use OhSeeSoftware\LaravelVeneer\Providers\MockedMethod;

class ListChannelsMock extends MockedMethod
{
    public function method(): string
    {
        return 'listChannels';
    }
}
```

By default, the only required method is `method(): string`, which tells Laravel Veneer which method of the `MockProvider` class you are mocking.

If you want your mocked method to return data from a fixture, define the path to the fixture via `fixturePath(): ?string`:

```php
public function fixturePath(): ?string
{
    return 'cronofy/responses/v1/channels/index.json';
}
```

If you need your mocked method to return something entirely custom (maybe a new instance of a different class, etc), you can override the `result()` method:

```php
public function result()
{
    return 'hello world!'; // Return 'hello world!' whenever this mocked method is called
}
```