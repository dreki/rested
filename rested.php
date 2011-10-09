<?php

namespace rested;

require_once __DIR__ . '/request.php';

/**
 * Main Rested class
 *
 * @author sgilbertson
 **/
class Rested {
    /**
     * Constructor
     *
     * @param array $config Overrides for anything that would be in $_SERVER.
     * @return void
     * @author sgilbertson
     **/
    public function __construct($config=array()) {
        $this->_init_request($config);
    }

    /**
     * Main front controller 'routing' function.
     *
     * @return void
     * @author sgilbertson
     **/
    public function go() {
        // var_dump($request_uri);
        diag_dump($this->_request);
    }

    /**
     * Current request.
     *
     * @var Request
     **/
    var $_request = null;

    /**
     * Determine the route to call.
     *
     * @param array $overrides (optional) Override anything that's normally in the $_SERVER.
     * @return void
     * @author sgilbertson
     **/
    private function _init_request($overrides=array()) {
        $REQUEST_URI = null;
        $REQUEST_METHOD = null;

        // Support passing in just a uri.
        if (is_string($overrides)) {
            $overrides = array(
                'REQUEST_URI' => $overrides,
                'REQUEST_METHOD' => 'GET',
            );
        }

        // Support routing from HTTP request, but don't require it.
        if (isset($_SERVER['REQUEST_URI'])) {
            extract($_SERVER);
        }

        // Use any overrides the caller gave us.
        extract($overrides);

        // Create the Request object.
        $this->_request = new \rested\Request(
            array(
                'uri' => $REQUEST_URI,
                'method' => $REQUEST_METHOD,
            )
        );
    }
} // END class Rested
