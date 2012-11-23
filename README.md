# Installálás

composer.json fájlba:
```
"repositories": [
    ...
    {
        "type": "vcs",
        "url": "https://github.com/loonkwil/pager-utilities.git"
    },
    ...
],
"require": {
    ...
    "spe/pager-utilities": "dev-master",
    ...
}
```

```
php composer.phar update
```
