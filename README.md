# gp-login-customizer

Change default login URL, Title, Styles, Logo, etc. Go to : Appearance -> Themes -> Customize -> Login Customizer
   
![Alt Text](https://raw.githubusercontent.com/german-pichardo/gp-login-customizer/master/wp-assets/screenshot.gif)

### Installation ##

- Upload the folder to the `/wp-content/plugins/` directory.
- Activate the plugin through the 'Plugins' menu in WordPress.

### Installation local

Clone project :

```bash
cd wp-content/plugins
git clone git@github.com:german-pichardo/gp-login-customizer.git
cd gp-login-customizer
```

### Install using composer

Add to your composer.json

```
"repositories": [
   ...
    {
      "type": "vcs",
      "url": "git@github.com:german-pichardo/gp-login-customizer.git"
    }
],
```
Run 
```bash
composer require gp/gp-login-customizer
```

### Development and Coding standards

Check [WordPress-Coding-Standards](https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards) with [PHPCS](https://github.com/squizlabs/PHP_CodeSniffer).

- `composer install` to install PHP dev dependencies
- `composer lint` to lint PHP files with [phpcs](https://github.com/squizlabs/PHP_CodeSniffer).
- `composer lint:fix` to fix the PHP files with [phpcbf](https://github.com/squizlabs/PHP_CodeSniffer).

### Author

**German Pichardo**

* [github/german-pichardo](https://github.com/german-pichardo)
* [http://german-pichardo.com](http://german-pichardo.com)
