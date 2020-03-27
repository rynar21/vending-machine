DIRECTORY STRUCTURE
-------------------

```
common
    config/              contains shared configurations
    mail/                contains view files for e-mails
    models/              contains model classes used in both backend and frontend
    tests/               contains tests for common classes    
console
    config/              contains console configurations
    controllers/         contains console controllers (commands)
    migrations/          contains database migrations
    models/              contains console-specific model classes
    runtime/             contains files generated during runtime
backend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains backend configurations
    controllers/         contains Web controller classes
    models/              contains backend-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for backend application    
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
frontend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains frontend configurations
    controllers/         contains Web controller classes
    models/              contains frontend-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for frontend application
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
    widgets/             contains frontend widgets
vendor/                  contains dependent 3rd-party packages
environments/            contains environment-based overrides
```

SETUP PROJECT ENVIRONMENT
-------------------

INITIALIZE PROJECT
```
$ composer init

$ php yii init

$ php yii migrate

```

SETUP BY DOCKER
----------------
```
$ docker-compose up -d
```

INITIALIZE DEFAULT USER
```
$ php yii user/create-admin "username" "password"
```

INITIALIZE FAKE DATA
```
$ php yii migrate --migrationPath=@console/migrations/fake/
```


CREATE NEW SINGLE ELASTIC BEANSTALK INSTANCE
```
$ eb create "vending-machine-dev" --keyname "vending-machine" --platform "php" --process --region "ap-southeast-1" --single
```




```
$file = UploadedFile::getInstanceByName("file");


if (!$file) {
    return [
        'error' => "Must upload at least 1 file in upfile form-data POST",
    ];
}

$extension  = $file->extension;
$data       = $file->tempName;
$filename = date('ymdHi') . '_' . uniqid() . '.' . $extension;

Yii::$app->s3->upload('products/' . $filename, $data, null, [
    'params' => [
        'CacheControl' => 'public, max-age=31536000',
    ]
]);
```
