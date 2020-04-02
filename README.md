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
$ eb create "vm-core" --keyname "payngo" --platform "php" --process --region "ap-southeast-1" --single
```

SETTING ENVIRONMENT VARIABLES
```
$ eb setenv \
ENV_NAME=development \
RDS_HOSTNAME=db \
RDS_DB_NAME=yii2advanced \
RDS_PORT=3306 \
RDS_USERNAME=root \
RDS_PASSWORD=root \
S3_KEY=S3_KEY_HERE \
S3_SECRET=S3_SECRET_HERE \
S3_REGION=ap-southeast-1 \
S3_BUCKET=s3_bucket_here
```
