# Documentation for `package.json`

Below the decisions made in our project's `package.json` file are explained.

## Dependencies

- [@popperjs/core](https://ghub.io/@popperjs/core): Peer dependency of Bootstrap
- [bootstrap](https://ghub.io/bootstrap): Front-end framework used for our UI
- [bootstrap-icons](https://ghub.io/bootstrap-icons): Icon library used in our UI
- [bootswatch](https://ghub.io/bootswatch): Collection of themes users can select when using our app
- [npm](https://ghub.io/npm): Current package manager

## Dev Dependencies

- [cypress](https://ghub.io/cypress): Cypress.io end to end testing tool
- [grunt](https://ghub.io/grunt): The JavaScript Task Runner
- [grunt-composer](https://ghub.io/grunt-composer): A grunt wrapper for composer
- [grunt-contrib-clean](https://ghub.io/grunt-contrib-clean): Clean files and folders
- [grunt-contrib-compress](https://ghub.io/grunt-contrib-compress): Compress files and folders
- [grunt-contrib-concat](https://ghub.io/grunt-contrib-concat): Concatenate files.
- [grunt-contrib-copy](https://ghub.io/grunt-contrib-copy): Copy files and folders
- [grunt-contrib-cssmin](https://ghub.io/grunt-contrib-cssmin): Minify CSS
- [grunt-contrib-jshint](https://ghub.io/grunt-contrib-jshint): Validate files with JSHint
- [grunt-contrib-uglify](https://ghub.io/grunt-contrib-uglify): Minify JavaScript files with UglifyJS
- [grunt-contrib-watch](https://ghub.io/grunt-contrib-watch): Run predefined tasks whenever watched file patterns are added, changed or deleted

## Scripts

When you run the command `npm run build`, task runner `grunt` will do it's thing\
`"scripts": { "build": "grunt" }`

## Miscellaneous

Brief explanation of used fields. These won't change very often.

For more info, see the NPM docs about the `package.json`: https://docs.npmjs.com/cli/v7/configuring-npm/package-json

Project name\
`"name": "opensourcepos"`

Project version using semver\
`"version": "x.x.x"`

Project description\
`"description": "..."`

Project license\
`"license": "MIT"`

Project keywords\
`"keywords": [ "..." ]`

Project homepage\
`"homepage": "https://opensourcepos.org/"`

URL to project issue tracker\
`"bugs": { "..." }`

Authors of the project\
`"authors": [ "..." ]`

Primary entry point for project\
`"main": "..."`

URL for funding/donations\
`"funding": "..."`

Specifying the place where the code lives\
`"repository": { "..." }`

Stops NPM from publishing the package.json\
`"private": true`

Default test script\
`"scripts": { "test": "echo \"Error: no test specified\" && exit 1" }`