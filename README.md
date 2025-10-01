# GridPlay Accounts

## Installation & Basic Usage

To use first install with composer
```json
    "require": {
        "gridplay/gridplayaccounts": "^1.0",
    }
```
```sh
composer update
```
or do...
```sh
composer require gridplay/gridplayaccounts
```
### Add configuration to `config/services.php`

```php
'gridplayaccounts' => [    
  'client_id' => env('GPA_CLIENT_ID'),  
  'client_secret' => env('GPA_CLIENT_SECRET'),  
  'redirect' => env('GPA_REDIRECT_URI') 
],
```

### Add provider event listener

#### Laravel 11+
In your Providers/AppServiceProvider.php put the following in the boot function
```php
use Illuminate\Support\Facades\Event;
use \GPA\GpaProvider;
    public function boot(): void
    {
        Event::listen(function (\SocialiteProviders\Manager\SocialiteWasCalled $event) {
            $event->extendSocialite('gridplayaccounts', GpaProvider::class);
        });
    }
```

### Usage

You should now be able to use the provider like you would regularly use Socialite (assuming you have the facade installed):

```php
return Socialite::driver('gridplayaccounts')->redirect();
```
```php
$user = Socialite::driver('gridplayaccounts')->user();
$gpid = $user->id;
$name = $user->name;
// etc.
```
### Returned User fields

- ``id``
- ``name``
- ``email``
