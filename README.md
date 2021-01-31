# gp-login-customizer

Change default login URL, Title, Styles, Logo, etc. Go to : Appearance -> Themes -> Customize -> Login Customizer
   
![Alt Text](https://raw.githubusercontent.com/german-pichardo/gp-login-customizer/master/wp-assets/screenshot.gif)

## Installation ##

- Upload the folder to the `/wp-content/plugins/` directory.
- Activate the plugin through the 'Plugins' menu in WordPress.

## Installation local

Clone project :

```bash
cd wp-content/plugins
git clone git@github.com:german-pichardo/gp-login-customizer.git
cd gp-login-customizer
```

### Development and Coding standards

Check [WordPress-Coding-Standards](https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards) with [PHPCS](https://github.com/squizlabs/PHP_CodeSniffer), [stylelint](https://www.npmjs.com/package/stylelint-config-wordpress) for CSS, and for JavaScript linting is done with [ESLint](https://eslint.org/).

- `composer install` to install PHP dev dependencies
- `composer lint` to lint PHP files with [phpcs](https://github.com/squizlabs/PHP_CodeSniffer).
- `composer lint:fix` to fix the PHP files with [phpcbf](https://github.com/squizlabs/PHP_CodeSniffer).

## Author

**German Pichardo**

* [github/german-pichardo](https://github.com/german-pichardo)
* [http://german-pichardo.com](http://german-pichardo.com)
