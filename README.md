Laravel Docs
-------------
This is a simple PHP server for laravel/docs markdown files. You can use this but its mainly for my personal use offline docs.

#### <i class="icon-refresh"></i> Installation

> **Note:** You will need to be able to run ```npm``` and ```composer``` commands from your terminal.

You will need to download/clone this repository _(duh)_. After cloning, run the following commands:

- Install **node_modules** (see package.json):
	```npm install --production --prefer-offline --no-audit --progress=false```
- Install **[laravel docs](https://github.com/laravel/docs.git)** (see composer.json):
	```composer install --no-dev -o```
- After installation, if ```php``` is in your path, you can then serve the website by running:
	```composer serve```

**_By @isthuku_**
