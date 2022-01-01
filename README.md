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

The goal of the package is to make mocking the 80% use case easy. There's three steps involved:

1. Create an instance of a `MockProvider`
2. Add the methods you want to mock to the `MockProvider`
3. Apply the mock

The simplest example is a one-liner:

```php
$this->veneer(CronofyMock::make()->add(CreateChannelMock::make()));
```

Where we:

- Make a new instance of the `MockProvider`: `CronofyMock::make()`
- Add a method to mock: `->add(CreateChannelMock::make())`
- Apply the mock using the exposed trait: `$this->veneer(...)`

Here's an example of a full test class using the package to a mock Cronofy's `createChannel` method:

```php
<?php

use OhSeeSoftware\LaravelVeneer\Providers\Cronofy\CreateChannelMock;
use OhSeeSoftware\LaravelVeneer\Providers\Cronofy\CronofyMock;
use OhSeeSoftware\LaravelVeneer\Traits\VeneerMocks;

class MyTest extends TestCase
{
    use VeneerMocks;
    
    public function testItDoesSomething()
    {
        // Given, mock the 3rd party SDK
        $this->veneer(CronofyMock::make()->add(CreateChannelMock::make()));

        // When, call your code that will call the 3rd party SDK
        $this->post('/channel');

        // Then, assert your code handled the 3rd party response correctly
        $this->assertDatabaseHas('channels', [
            'cronofy_channel_id' => 'chn_0000000000'
        ]);
    }
}
```

If you're wondering where the hard coded `chn_0000000000` comes from, it comes from the [fixture data](https://github.com/ohseesoftware/laravel-veneer/blob/master/fixtures/cronofy/responses/v1/channels/post.json#L3) that has been defined.

### Using the trait

The `VeneerMocks` trait defines a single method which sets the current `$application` instance on the given provider, and then calls the `mock` method. The `mock` method will apply the mocked methods as a partial mock via Laravel's `$this->partialMock` method.

### Overriding mock responses

If you're not satisfied with the default fixture response, you can override it yourself:

```php
$this->veneer(
    CronofyMock::make()->add(
        CreateChannelMock::make()->return('Hello world!')
    )
);
```

Now, when the `createChannel` method is called, it will return 'Hello world!' instead of the default fixture data.

### Merging mock responses with your data

Okay, well now let's say you only want to tweak one part of the fixture data, say the channel ID that is returned. You can do so via the `merge($key, $value)` method:

```php
$this->veneer(
    CronofyMock::make()->add(
        CreateChannelMock::make()->merge('channel.channel_id', 'chn_123456')
    )
);
```

Now, when the `createChannel` method is called, it will return the default fixture data, but the `channel.channel_id` value will be set to `chn_123456`, which means your test would now look like:

```php
public function testItDoesSomething()
{
    // Given, mock the 3rd party SDK with a custom `channel.channel_id` value
    $this->veneer(
        CronofyMock::make()->add(
            CreateChannelMock::make()->merge('channel.channel_id', 'chn_123456')
        )
    );

    // When, call your code that will call the 3rd party SDK
    $this->post('/channel');

    // Then, assert your code handled the 3rd party response correctly
    $this->assertDatabaseHas('channels', [
        'cronofy_channel_id' => 'chn_123456'
    ]);
}
```

### Expecting arguments

You can utilize Mockery's `withArgs` method via `with(...$args)` method:

```php
$this->veneer(
    CronofyMock::make()->add(
        CreateChannelMock::make()->with('test')
    )
);
```

When the mocked method is called, it will verify that the value `test` was passed into the method. If `test` is not passed, the test will fail.

### Calling the mocked method multiple times

By default, Laravel Veneer expects that all mocked methods will be called once. However, if you need to have the method mocked for multiple calls, you can use the `times(int $times)` method:

```php
$this->veneer(
    CronofyMock::make()->add(
        CreateChannelMock::make()->times(3)
    )
);
```

In the above example, if the mocked method is not called exactly 3 times, the test will fail.


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

1. Add a new class to define which class you are mocking, we call this a `MockProvider`
2. Add a new class for the method you are mocking, we call this a `MockedMethod`

#### Adding a new `MockProvider`

The `MockProvider` usage is quite simple. All you need to do is extend the `MockProvider` class and then implement a method telling Laravel Veneer which class you are mocking:

```php
<?php

namespace OhSeeSoftware\LaravelVeneer\Providers\Cronofy;

use OhSeeSoftware\LaravelVeneer\Providers\MockProvider;

class CronofyMock extends MockProvider
{
    /**
     * FQDN of the class being mocked.
     */
    public function mockedClass(): string
    {
        // Laravel Veneer will apply a partial mock to the `\Cronofy\Cronofy` class
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
        /**
         * Name of the method being mocked.
         */
        return 'listChannels';
    }
}
```

By default, the only required method is `method(): string`, which tells Laravel Veneer which method of the `MockProvider` class you are mocking.

If you want your mocked method to return data from a fixture, define the path to the fixture via `fixturePath(): ?string`:

```php
/**
 * Path to the fixture data file, if applicable.
 *
 * The value should be a relative path from the `fixtures` directory.
 */
public function fixturePath(): ?string
{
    return 'cronofy/responses/v1/channels/index.json';
}
```

If you need your mocked method to return something entirely custom (maybe a new instance of a different class, etc), you can override the `result()` method:

```php
/**
 * The result returned from the mocked method.
 */
public function result()
{
    return 'hello world!'; // Return 'hello world!' whenever this mocked method is called
}
```