# GridPlay Accounts

## Installation & Basic Usage

To use first install with composer
```json
    "require": {
        "gridplay/gpa": "^1.0",
    }
```
```sh
composer update
```
or do...
```sh
composer require gridplay/gpa
```
### Add configuration to `config/services.php`

```php
'gpa' => [    
  'client_id' => env('GPA_CLIENT_ID'),  
  'client_secret' => env('GPA_CLIENT_SECRET'),  
  'redirect' => env('GPA_REDIRECT_URI') 
],
```

### Add provider event listener

#### Laravel 10 and below
Configure the package's listener to listen for `SocialiteWasCalled` events.

Add the event to your `listen[]` array in `app/Providers/EventServiceProvider`. See the [Base Installation Guide](https://socialiteproviders.com/usage/) for detailed instructions.

```php
protected $listen = [
    \SocialiteProviders\Manager\SocialiteWasCalled::class => [
        // ... other providers
        \GPA\GPAExtendSocialite::class.'@handle',
    ],
];
```

#### Laravel 11+
In your Providers/AppServiceProvider.php put the following in the boot function
```php
use Illuminate\Support\Facades\Event;
use \GPA\GpaProvider;
    public function boot(): void
    {
        Event::listen(function (\SocialiteProviders\Manager\SocialiteWasCalled $event) {
            $event->extendSocialite('gpa', GpaProvider::class);
        });
    }
```

### Usage

You should now be able to use the provider like you would regularly use Socialite (assuming you have the facade installed):

```php
return Socialite::driver('gpa')->redirect();
```
```php
$user = Socialite::driver('gpa')->user();
$gpid = $user->id;
$name = $user->name;
// etc.
```
### Returned User fields

- ``id``
- ``grid``
- ``name``
- ``email``
- ``points``
