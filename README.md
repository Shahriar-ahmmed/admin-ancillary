Ahmmed/AdminAncillary

Laravel Ahmmed/AdminAncillary check the role based permissions to built in Auth System of Laravel 5.
AdminAncillary protects routes and even crud controller methods.

Table of Contents

Requirements

Getting Started

Documentation

Contribution Guidelines


Requirements

    This package requires PHP 5.6+

Getting Started

    Publish the package migrations,asset and views to your application
    
    php artisan vendor:publish --provider="Ahmmed\AdminAncillary\AdminAncillaryServiceProvider"
    
    After successful publish, Add the role relationship method and user_role fillable field  to your User model.
    
    public function role(){
        return $this->hasOne(Role::class,'id','user_role');
    }
    
    After that run 
    
    "php artisan migrate"
    
    Add the middleware to your app/Http/Kernel.php.

    protected $routeMiddleware = [
    'check_permission' => 'Ahmmed\AdminAncillary\CheckPermission',
    ];
    
    If your application have no error view page then add error view page.

    Also add DEFAULT_LOGO and DEFAULT_FAVICON in your .env file for upload logo and favicon in app settings 
    
Documentation

    Follow along the Wiki to find out more.
   
Contribution Guidelines

    Support follows PSR-2 PHP coding standards, and semantic versioning.
    
    Please report any issue you find in the issues page. Pull requests are welcome.