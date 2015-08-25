# Basey

Basey is a developer-friendly WordPress base (or parent) theme built with [UIkit](https://github.com/uikit/uikit) and [GulpJS](http://gulpjs.com).

Extremely flexible, easy to customize and adheres to WordPress coding standards for a friendlier theming experience.

## Customization: Getting Started

* Make sure you have the following installed:
  * [NodeJS](http://nodejs.org)
  * [Bower](http://bower.io)
  * [Gulp](http://gulpjs.com)
* Have a vhost setup for `wordpress.dev`. You can change this to your liking in `gulpfile.js`; needed for BrowserSync
* In your terminal, navigate to your theme's directory and run the following:
  * `bower install`
    * Installs necessary frontend assets
  * `npm install`
    * Installs Gulp and Gulp plugins for compiling assets
  * `gulp`
     * Builds initial project
   * `gulp watch`
     * Watches for project changes

Enjoy!