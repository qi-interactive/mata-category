MATA Category
==========================================

Manages categories for Active Record models

Installation
------------

- Add the module using composer:

```json
"mata/mata-category": "~1.0.0"
```

-  Run migrations
```
php yii migrate/up --migrationPath=@vendor/mata/mata-category/migrations
```


Changelog
---------

## 1.0.1.1-alpha, September 7, 2016

- Added migration (alter DocumentId from 64 to 128 characters)

## 1.0.1-alpha, August 21, 2015

- Added deletion of categories for removed document
- [[Category]] model uses [[matacms\db\ActiveQuery]]

## 1.0.0-alpha, May 18, 2015

- Initial release.
