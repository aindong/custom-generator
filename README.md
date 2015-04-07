# Laravel Custom Generator
A laravel custom generator inspired by the generator packaged of jeffrey way. This generator will generate files that are needed for a repository pattern structure.


## Installation
1. Add this into your laravel composer.json file, under require
```
"require-dev": {
  "aindong/custom-generator": "dev-master"
}
```

2. Open up your terminal and run
```
composer update
```

3. After downloadign the package. Open up your app/config/app.php file and inside the $providers array add this

```
'Aindong\CustomGenerator\Providers\CustomGeneratorServiceProvider',
```

4. If errors occured like, it can't find the package. Run
```
composer dumpautoload -o
```

## Usage
1. Inside your app folder, create a customized folder name that will contain all of your features. For example I created an Acme Folder
```
-app
--Acme
```

2. And under your custom folder, create a Features folder.
```
-app
--Acme
---Features
```

3. Now on your terminal, type
```
php artisan generate:feature featurename --path=app/Acme --namespace=Acme
```

4. TADA! now check your features folder for the magic!


## Notes
This package is still under development but I'm already using it to make my work faster and reduce the time of creating new files and restructuring them. Feel free to suggest.
