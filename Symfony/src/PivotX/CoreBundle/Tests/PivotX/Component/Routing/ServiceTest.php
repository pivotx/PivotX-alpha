<?php

/**
 * This file is part of the PivotX Core bundle
 *
 * (c) Marcel Wouters / Two Kings <marcel@twokings.nl>
 */

namespace PivotX\CoreBundle\Component\Routing;

use Symfony\Bridge\Monolog\Logger;
use PivotX\Component\Routing\Service;
use PivotX\Component\Routing\Route;
use PivotX\Component\Referencer\Reference;

/**
 * Test routeservice
 *
 * This is a first draft of the tests.
 *
 * @author Marcel Wouters <marcel@twokings.nl>
 */
class ServiceTest extends \PHPUnit_Framework_TestCase
{
    protected $yaml_text;

    public function setUp()
    {
        $this->yaml_text = <<<THEEND

# Site configuration

targets:
    - name:         "desktop"
      description:  "Desktop or tablet"

    - name:         "mobile"
      description:  "Mobile"

sites:
    - name:         "main"
      description:  "Main site"

languages:
    - name:         "nl"
      description:  "Dutch"
      locale:       "nl_NL.utf-8"

    - name:         "en"
      description:  "English"
      locale:       "en_GB.utf-8"


routeprefixes:
    - filter:       { target: "desktop", site: "main", language: "nl" }
      prefix:       "http://pivotx.com/nl/"
      aliases:
          - "http://www.pivotx.com/nl/"

    - filter:       { target: "mobile", site: "main", language: "nl" }
      prefix:       "http://m.pivotx.com/nl/"

    - filter:       { target: "mobile", site: "main", language: "en" }
      prefix:       "http://m.pivotx.com/"

    - filter:       { target: "desktop", site: "main", language: "en" }
      prefix:       "http://pivotx.com/"
      aliases:
          - "http://www.pivotx.com/"

routes:
    - filter:       { target: false, site: "main", language: false }
      pattern:      "_page/frontpage"
      public:       ""
      defaults:     { }

    - filter:       { target: "desktop", site: "main", language: "en" }
      pattern:      "_page/latest-news"
      public:       "latest-news"
      defaults:     { _rewrite: "(site=main&language=en)@archive/0000-00" }

    - filter:       { target: "desktop", site: "main", language: "nl" }
      pattern:      "_page/latest-news"
      public:       "laatste-nieuws"
      defaults:     { _rewrite: "(site=main&language=nl)@archive/0000-00" }

    - filter:       { target: "desktop", site: "main", language: "en" }
      pattern:      "archive/{yearmonth}"
      public:       "archive/{yearmonth}"
      defaults:     { _controller: "PivotXCoreBundle:Debug:showArchive" }
      requirements:
          yearmonth: "[0-9]{4}-[0-9]{2}"

    - filter:       { target: "desktop", site: "main", language: "nl" }
      pattern:      "archive/{yearmonth}"
      public:       "archief/{yearmonth}"
      defaults:     { _controller: "PivotXCoreBundle:Debug:showArchive" }
      requirements: 
          yearmonth:  "[0-9]{4}-[0-9]{2}"

    - filter:       { target: "desktop", site: "main", language: "en" }
      pattern:      "_page/contact"
      public:       "conference"
      defaults:     { _redirect: "(site=main&language=en)@entry/1" }

    - filter:       { target: [ "desktop", "mobile" ], site: "main", language: "nl" }
      pattern:      "entry/{id}"
      public:       "nieuws/{publicid}"
      defaults:     { _controller: "PivotXCoreBundle:Debug:showEntity", _conversion: "PivotX\\CoreBundle\\Controller\\DebugController::convertArguments" }
      requirements:
        id:         "\d+"
        publicid:   "(\d+|[a-z0-9_-]+)"

    - filter:       { target: [ "desktop", "mobile" ], site: "main", language: "en" }
      pattern:      "entry/{id}"
      public:       "news/{publicid}"
      defaults:     { _controller: "PivotXCoreBundle:Debug:showEntity", _conversion: "PivotX\\CoreBundle\\Controller\\DebugController::convertArguments" }
      requirements:
        id:         "\d+"
        publicid:   "(\d+|[a-z0-9_-]+)"

    - filter:       { target: "desktop", site: "main", language: [ "nl","en" ] }
      pattern:      "_page/agenda"
      public:       "agenda"
      defaults:     { _rewrite: "archive/0000-01" }

    - filter:       { target: "desktop", site: "main", language: "en" }
      pattern:      "_page/infinite-self"
      public:       "infinite-self"
      defaults:     { _redirect: "_page/infinite-self" }

    - filter:       { target: "desktop", site: "main", language: "en" }
      pattern:      "_page/infinite-loop"
      public:       "infinite-loop"
      defaults:     { _rewrite: "_page/infinite-loop2" }

    - filter:       { target: "desktop", site: "main", language: "en" }
      pattern:      "_page/infinite-loop2"
      public:       "infinite-loop2"
      defaults:     { _rewrite: "_page/infinite-loop" }

    - filter:       { target: "desktop", site: "main", language: "en" }
      pattern:      "_page/route-not-found"
      public:       "route-not-found"
      defaults:     { _redirect: "_page/not-found" }
THEEND;

        $this->logger = new Logger('test-logger');

        $this->routeservice = new Service($this->logger);

        $this->routeservice->processTextConfig($this->yaml_text);
    }

    public function testYaml()
    {
        $routesetup = $this->routeservice->getRouteSetup();

        $this->assertNotNull($routematch = $routesetup->matchUrl('http://pivotx.com/'));
        $this->assertNotNull($reference = $routematch->buildReference(null));
        $this->assertEquals($reference->buildTextReference(),'(site=main&target=desktop&language=en)@_page/frontpage');

        $this->assertNotNull($routematch = $routesetup->matchUrl('http://m.pivotx.com/nl/'));
        $this->assertNotNull($reference = $routematch->buildReference(null));
        $this->assertEquals($reference->buildTextReference(),'(site=main&target=mobile&language=nl)@_page/frontpage');

        $this->assertNotNull($routematch = $routesetup->matchUrl('http://pivotx.com/news/public-id'));
    }
}
