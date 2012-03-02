<?php

/*
Option #A:
http://pivotx.com/      - en, desktop
http://pivotx.nl/       - nl, desktop
http://m.pivotx.com/    - en, mobile
http://m.pivotx.nl/     - nl, mobile
http://pivotx.com/book/ - en, *

Option #B:
http://pivotx.com/      - en, desktop
http://pivotx.com/nl/   - nl, desktop
http://m.pivotx.com/    - en, mobile
http://m.pivotx.com/nl/ - nl, mobile
*/


/**
 * this is fully automated, can be configured
 */


/**
 * this could almost be fully automated, can be configured
 */

$routesetup = new RouteSetup();
$routesetup
    ->addSite(new Site('main', 'Main site'))
    ->addSite(new Site('book', 'PivotX socumentation site'))
    ->addLanguage(new Language('en', 'English', 'en_GB.utf8'))
    ->addLanguage(new Language('nl', 'Dutch', 'nl_NL.utf8'))
    ->addTarget(new Target('desktop', 'Desktop'))
    ->addTarget(new Target('mobile', 'Mobile'))
    ->addEntity(new Entity('category', 'Classic PivotX category'))
    ->addEntity(new Entity('entry', 'PivotX entry'))
    ->addEntity(new Entity('page', 'PivotX page'))
    ;


/**
 * this should always be configured, can be autoconfigured with a hostname
 */

$routeprefixes = new RoutePrefixes($routesetup);
$routeprefixes
    ->add(new RoutePrefix('http://pivotx.com/book/', array('http://www.pivotx.com/book/')))
        ->filterSite('book')
        ->filterLanguage('en')
    ->add(new RoutePrefix('http://pivotx.com/nl/', array('http://www.pivotx.com/nl/')))
        ->filterSite('main')
        ->filterLanguage('nl')
        ->filterTarget('desktop')
    ->add(new RoutePrefix('http://m.pivotx.com/nl/'))
        ->filterSite('main')
        ->filterLanguage('nl')
        ->filterTarget('mobile')
    ->add(new RoutePrefix('http://pivotx.com/', array('http://www.pivotx.com/')))
        ->filterSite('main')
        ->filterLanguage('en')
        ->filterTarget('desktop')
    ->add(new RoutePrefix('http://m.pivotx.com/'))
        ->filterSite('main')
        ->filterLanguage('en')
        ->filterTarget('mobile')
    ;


/**
 * actual routes, standard inclusion, can be configured
 *
 * Routes are come first, serve first
 * Default regex check for fast matching
 * Rewrite/redirect options
 * preroute(..) call
 * - can suggest 'skip me'
 * - can rewriting route
 * - can give cache suggestions
 * controller(..) works as regular Symfony controller
 */

$routecollection = new RouteCollection($routesetup);
$routecollection

    // THIS STYLE: custom routes
    ->add(
        array(
            'language' => array ( 'en' ),
        ),
        new Route(
            '_page/latest-news', 'latest-news',
            array(),
            array( 'rewrite' => 'archive/'.date('Y-m') )        // <- maybe not do this date() thing
        ))

    // .. not this style: custom routes
    ->add(new Route('latest-news', '_page/latest-news'))
        ->filterLanguage('en')
        ->setRequirements()             // <- can be removed in this case
        ->setOptions(array('rewrite' => 'archive/'.date('Y-m')))
                                        // ^- maybe not do this date() thing

    // custom routes
    ->add(new Route(
            'lang=en', '_page/latest-news', 'latest-news',
            array(),
            array( 'rewrite' => 'archive/'.date('Y-m') )        // <- maybe not do this date() thing
        ))
    ->add(new Route(
            'lang=nl', '_page/latest-news', 'laatste-nieuws',
            array(),
            array( 'rewrite' => 'archive/'.date('Y-m') )        // <- maybe not do this date() thing
        ))

    // handy things
    ->add(new Route(
            'lang=nl', '', 'belasting',
            array(),
            array ( 'redirect' => 'categorie/belasting' )
        ))

    // special routes
    ->add(new Route(
            '', '', '{all}',
            array(),
            array( 'preroute' => 'prerouteSpecials', 'controller' => false )
        ))

    // regular entity routes
    ->add(new Route(
            'lang=en', 'category/{id}', 'category/{publicid}',
            array(),
            array( 'preroute' => 'prerouteCategory', 'controller' => 'showCategory' )
        ))
    ->add(new Route(
            'lang=nl', 'category/{id}', 'categorie/{publicid}',
            array(),
            array( 'preroute' => 'prerouteCategory', 'controller' => 'showCategory' )
        ))
    ->add(new Route(
            'lang=en', 'archive/{yearmonth}', 'archive/{yearmonth}',
            array( 'yearmonth' => '[0-9]{4}-[0-9]{2}' ),
            array( 'preroute' => 'prerouteArchive', 'controller' => 'showArchive' )
        ))
    ->add(new Route(
            'lang=nl', 'archive/{yearmonth}', 'archief/{yearmonth}',
            array( 'yearmonth' => '[0-9]{4}-[0-9]{2}' ),
            array( 'preroute' => 'prerouteArchive', 'controller' => 'showArchive' )
        ))
    ->add(new Route(
            'lang=en', 'entry/{id}', 'entry/{publicid}',
            array(),
            array( 'preroute' => 'prerouteEntry', 'controller' => 'showEntry' )
        ))
    ->add(new Route(
            'lang=nl', 'entry/{id}', 'bericht/{publicid}',
            array(),
            array( 'preroute' => 'prerouteEntry', 'controller' => 'showEntry' )
        ))
    ->add(new Route(
            'lang=en', 'page/{id}', 'page/{publicid}',
            array(),
            array( 'preroute' => 'preroutePage', 'controller' => 'showPage' )
        ))
    ->add(new Route(
            'lang=nl', 'page/{id}', 'pagina/{publicid}',
            array(),
            array( 'preroute' => 'preroutePage', 'controller' => 'showPage' )
        ))

    // redirects
    ->add(new Route(
            '', '', '{all}',
            array(),
            array( 'controller' => 'redirectUrls' )
        ))

    // fallback routes
    ->add(new RouteHttp(
            '', '_http/500', '',
            array(),
            array( 'controller' => 'showHttpError' )
        ))
    ->add(new RouteHttp(
            '', '_http/404', '',
            array(),
            array( 'controller' => 'showHttpError' )
        ))
    ;

// example Symfony route
$route = new Route(
    '/category/{id}', // path
    array('controller' => 'showArchive'), // default values
    array('month' => '[0-9]{4}-[0-9]{2}'), // requirements
    array() // options
);

?>
