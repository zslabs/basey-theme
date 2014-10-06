# Basey

Basey is a developer-friendly WordPress base (or parent) theme built with [UIkit](https://github.com/uikit/uikit) and [GulpJS](http://gulpjs.com).

Extremely flexible, easy to customize and adheres to WordPress coding standards for a friendlier theming experience.

## Customization: Getting Started

* Make sure you have the following installed:
    * [NodeJS](http://nodejs.org)
    * [Bower](http://bower.io)
    * [Gulp](http://gulpjs.com)
* In your terminal, navigate to your theme's directory and run the following:
    * `bower install`
    	* Installs necessary frontend assets
    * `npm install`
    	* Installs Gulp and Gulp plugins for compiling assets
    * `gulp`
   		* Builds initial project
   	* `gulp watch`
   		* Watches for project changes

This project uses [BrowserSync](http://www.browsersync.io/) to automatically watch, compile, reload, etc. Change the proxy variable in the gulpfile to match your environment before starting.

Enjoy!