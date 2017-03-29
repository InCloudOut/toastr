# Laravel Toastr
[![Build Status](https://travis-ci.org/InCloudOut/toastr.svg?branch=master)](https://travis-ci.org/InCloudOut/toastr)
[![Latest Stable Version](https://poser.pugx.org/incloudout/toastr/v/stable)](https://packagist.org/packages/incloudout/toastr)
[![Total Downloads](https://poser.pugx.org/incloudout/toastr/downloads)](https://packagist.org/packages/incloudout/toastr)
[![License](https://poser.pugx.org/incloudout/toastr/license)](https://packagist.org/packages/incloudout/toastr)

Laravel Toastr uses [toastr.js](https://github.com/CodeSeven/toastr) to display flash messages.

Inspired by [https://github.com/oriceon/toastr-5-laravel](https://github.com/oriceon/toastr-5-laravel)


**Please note that this package was tunned for Laravel 5.4**

## Installation
    
Run `composer require incloudout/toastr` to pull down the latest version of Laravel Toastr.

Edit `config/app.php` add the `provider` and the `alias` 

``` 
'providers' => [
    ...
    InCloudOut\Toastr\ToastrServiceProvider::class,
],
'aliases' => [
    ...
    'Toastr' => InCloudOut\Toastr\Facades\Toastr::class
],

``` 
#####  To install `toastr.js` via `npm`

Run `npm i --save-dev toastr`
 
Open `resources/assets/sass/app.scss` and add:
    
    ...
    @import "node_modules/toastr/toastr";
    
Open `resources/assets/js/bootstrap.js` and add:
        
    ...
    window.$ = window.jQuery = require('jquery');
    
    window.toastr = require('toastr');
    ...
    
Run `npm run dev` for development or `npm run build` for production 

#####  To require `toastr.js` via `html`

Go to your html master page and add:

```
<head>
...
<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
</head>
<body>
...
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</body>
```
**Note that `toastr.js` requires `JQuery` as a dependency**
## Configuration

You can start by publishing the configuration files. Run the following command

    $ php artisan vendor:publish --provider=InCloudOut\\Toastr\\ToastrServiceProvider

You can change the default options with other options, see [toastr.js demo](http://codeseven.github.io/toastr/demo.html) to choose what suits you.

## Usage

Add this code to your blade template file:
``` 
{!! Toastr::execute() !!}
```
Call one of these methods in your controllers to insert a toast:
  - `Toastr::warning($message, $title = null, $options = [])` - to add a warning toast
  - `Toastr::error($message, $title = null, $options = [])` - to add an error toast
  - `Toastr::info($message, $title = null, $options = [])` - to add an info toast
  - `Toastr::success($message, $title = null, $options = [])` - to add a success toast
  - `Toastr::add($type = warning|error|info|success, $message, $title = null, $options = [])` - to add a `$type` toast
  - **`Toastr::clear()` - clear all current toasts**

Use Laravel's session flash message. Make sure that your configuration `toastr.session` is set to `true`
  - Simple usage: 
```
    session()->flash('success', 'User Created);
```
  - Advanced usage: 
``` 
    session()->flash('success', [
        'message' => 'User Created',
        'title' => 'SUCCESS'
    ]);
```
    
