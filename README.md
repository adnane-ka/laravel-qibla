# Laravel-Qibla 
- a laravel package to get the Qiblaa direction based on given cords or user location (based on analysing the IP service from geoplugin.net )

# installation 
- via composer : 
``` 
composer require adnane/laravel-qibla
```
- the package's service provider will be auto-loaded as you can add it in ```config\app.php``` in the providers array 
```php 
'providers' => [
    ..
    'Adnane\Qibla\QiblaServiceProvider',
],
```

# example of use 
```php 
use Adnane\Qibla\Qibla;

// get Qibla direction based on user location 
echo Qibla::getDirection();

// As you can specify a longitude & latitude to calculate the Qibla direction from 
echo Qibla::getDirection($longitude , $latitude); 
```
# use in blade files

``` 
Hey User .. The kibla direction is about @qibla(36.6862,6.3633) ° North 
```
# how to interpretate the results 
- as mentioned ,Results are angles returned in degree scale : ex (108.2323° north) , so this can be easy to be handled using a degree compass or a front-end simple logic to achieve that.  

![image](https://www.pngarea.com/pngs/3/5012644_compass-png-boxing-the-compass-with-degree-png.png)


# See also  
[Laravel Speaks Arabic](https://github.com/adnane-ka/laravel-speaks-arabic)