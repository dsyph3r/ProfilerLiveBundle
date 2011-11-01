# ProfilerLiveBundle

## Overview

Provides a realtime interface for the Symfony2 WebProfilerBundle. Requests
and responses can be viewed in realtime while navigating through a Symfony2 application.
Important information is displayed with each profile including request URL,
response status code, any exception details, doctrine information, memory usage
and more.

![profiler_live_bundle](https://github.com/dsyph3r/ProfilerLiveDemo/raw/master/src/Profiler/DemoBundle/Resources/public/images/screenshot.jpg)

## Features

 * See realtime requests/responses from your Symfony2 application including:
   * Memory usage
   * Response Time
   * Response Status Code
   * Controller and Route
   * Any Exceptions
   * Resonse Content Type
 * See Sub Requests
 * Filter by:
   * Request URL
   * Request Method
   * Response Status Code
   * Response Content Type
 * Color coded response types to easily spot errors, 404's and redirects
 * Easily links to WebProfilerBundle for full details of profile

## Dependancies

 * WebProfilerBundle

If you are using the Symfony2 Standard Distribution the WebProfilerBundle
is already installed and configured.

## Installation

1. Add ProfilerLiveBundle to `vendor` dir:

    * Using vendors script

        Add the following to the `deps` file:

            [ProfilerLiveBundle]
                git=git://github.com/dsyph3r/ProfilerLiveBundle.git
                target=/bundles/Profiler/LiveBundle

        Run the vendors script:

            $ php bin/vendors install

    * Using git submodules:

            $ git submodule add git://github.com/dsyph3r/ProfilerLiveBundle.git vendor/bundles/Profiler/LiveBundle

2. Add the Profiler namespace to your autoloader:

        // app/autoload.php
        $loader->registerNamespaces(array(
            // ..
            'Profiler'    => __DIR__.'/../vendor/bundles',
        ));

3. Add bundle to application kernel:

        // app/ApplicationKernel.php
        public function registerBundles()
        {
            return array(
                // ...
                new Profiler\LiveBundle\ProfilerLiveBundle(),
            );
        }

4. Add routing for ProfilerLiveBundle:

        # app/config/routing_dev.yml
        ProfilerLiveBundle:
            resource: "@ProfilerLiveBundle/Resources/config/routing.yml"
            prefix:   /

5. Clear Cache

        $ php app/console cache:clear

6. Install assets:

        $ php app/console assets:install --symlink web

Point your browser to `http://yourdomain.com/app_dev.php/_live_profiler` to run
the live profiler. Browse your application as normal in another tab/window.

## Usage

The ProfilerLiveBundle is configured to use the existing Storage engine, by default
in the Symfony2 Standard Distribution this uses Sqlite. If you would like to
use MySql instead simply add the following paramaters to the file at
`app/config/parameters.ini`.

````
[parameters]
    profiler.storage.dsn = "mysql:host=localhost;dbname=profiler;"
    profiler.storage.username = %database_user%
    profiler.storage.password = %database_password%
    profiler.storage.class = Profiler\LiveBundle\Profiler\Storage\MysqlProfilerStorage
````

## Contributing

The WebProfilerBundle uses a number of external libries including jQuery,
jQuery UI and underscore. CoffeeScript is also used so you must not edit the JavaScript
files in the folder `Resources/public/js`. Instead edit the
CoffeeScript files and compile this to JavaScript using something like the
following:

````bash
$ coffee --watch -o Resources/public/js -c Resources/data/coffee
````

## Future features

There are a number of features I'd like to implement including:

 * Add support for additional DataCollectors in the
   [WebProfilerExtraBundle](https://github.com/Elao/WebProfilerExtraBundle)
   so output for Assetics, Twig, Routing and the Container can be captured.
 * Add ability to Pause, Play and Step through the requests.
 * Memory management - At present there is no management of profiles, this will
   cause problems when a lot of requests have been sent over.
 * Add ability to load historic profiles - between date/time ranges.
 * Add more information into the Live Profile view. Information such as POST parameters
   should be available without having to click through to the WebProfilerBundle.
 * Possibly port over to Backbone.js. There wouldn't be more work in this as it
   is already using underscore.js and there are Model classes already defined.
 * Use Assetic to complie and output the CoffeeScript files into JavaScript.
 * Add support for graphing of profiled information such as number of database requests

## Changelog

 * v0.1 (2011-10-20) - Initial release
