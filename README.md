Grafizzi
========

Welcome to Grafizzi, a PHP wrapper for AT&T GraphViz.

1) Installing Grafizzi
----------------------

### a) Obtain the Grafizzi sources

With Grafizzi being very new, the easiest way to get started is to clone the
Git repository.

    git clone https://github.com/FGM/grafizzi.git

### b) Download the dependencies

Once you have a clone of the Grafizzi repository, you need to install its
dependencies, using the Composer package dependency manager. Download Composer 
following the instructions on http://getcomposer.org/ , typically like this:

    curl -s http://getcomposer.org/installer | php

Then run:

    php composer.phar install
 
### c) Check your System Configuration

Now make sure that your local system is properly configured for Grafizzi. To do 
this, execute:

    php app/hello-node.php

You should see a detailed debug execution trace. On a POSIX system, you can get
just the resulting GraphViz source by redirecting stderr to /dev/null:

    php app/hello-node.php 2> /dev/null

You should see a very basic GraphViz source:

    graph g {
      rankdir="TB";
      label="Some graph";

      n1 [ label="Some node" ];
      n2 [ label="Other node" ];
      n1 -- n2;
    } /* /graph g */

If you get any warnings or recommendations, or nothing at all, check your PHP
error log, and fix these now before moving on.

2) Generating documentation
---------------------------

If your system includes the make command, and GraphViz itself, you can generate
a fully indexed source documentation by running:

    make docs
    
This will generate a HTML documentation with internal search engine in the 
doxygen/ directory. Use it by browsing to doxygen/html/index.html

The documentation and search engine are  even usable over file:/// URLs, so you
do not need a web server to access it.

3) Running tests
----------------

If you want to make sure that Grafizzi runs fine on your system, make sure 
that PHPunit 3.5 or later is installed on your system, and run:

    make test

5) Using Grafizzi in your PHP GraphViz projects
-----------------------------------------------

Grafizzi is available from https://github.com/FGM/grafizzi and declared
on http://packagist.org, making it available to your projects using Composer.

Just declare `osinet/grafizzi: *` in the `require` section of your 
`composer.json` and Composer will fetch Grafizzi and include it in the
autoloader map it will generate for your project.

6) Cleaning up
--------------

You can remove php_error.log, the generated doxygen docs directory, and many
stray generated files by running:

    make clean


Have fun!

