# Syntax tree

Illustration:

![](http://storage4.static.itmages.com/i/16/0822/h_1471904775_1029147_56b293341e.png)

## How to install

Execute commands below:

```
git clone git@github.com:mnvx/syntax-tree.git
cd syntax-tree
composer install
cp src/api/Config/Configuration.php.tpl src/api/Config/Configuration.php
```

Edit configuration file: `src/api/Config/Configuration.php`

Set `public` path as root directory for web server.

## How to use

Send POST request with next params.

`curl -d text="Мама мыла раму." -d format="JSON" http://<host where syntax-tree installed>`

You will achieve next result:

`[{"number":"2","text":"\u043c\u044b\u043b\u0430","children":[{"number":"1","text":"\u041c\u0430\u043c\u0430","children":[]},{"number":"3","text":"\u0440\u0430\u043c\u0443.","children":[]}]}]`
