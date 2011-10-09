<?php

namespace rested;

require_once __DIR__ . '/clienterrorexception.php';

/**
 * Class representing a request to Rested.
 *
 * @package default
 * @author sgilbertson
 **/
class Request {
    /**
     * Constructor.
     *
     * @param array $config Keys: uri, method.
     * @return void
     * @author sgilbertson
     **/
    public function __construct($config) {
        $uri = null;
        extract($config);

        // Sanitize uri.
        $uri = str_replace('//', '/', $uri);

        /*
         * Separate uri into components.
         */
        $uri = explode('/', $uri);

        diag("before");
        diag_dump($uri);

        // Get rid of empty strings where '/' were.
        $uri = array_filter(
            $uri,
            function ($val) {
                if (empty($val)) {
                    return false;
                }
                else {
                    return true;
                }
            }
        );

        // Reindex array, so it goes 0, 1, 2, etc., again.
        $uri = array_values($uri);

        diag("after");
        diag_dump($uri);

        /*
         * Determine which method to call, and call it.
         */
        // Class to use.
        $class = $uri[0];

        if (class_exists($class)) {
        }
        else {
            throw new \rested\ClientErrorException();
        }
    }

    /**
     * Class whose method we will call.
     *
     * @var string
     **/
    private $class;

    /**
     * Configuration/parameters to give to method. Can include things like POST/GET params.
     *
     * @var array
     * @see $method
     **/
    private $config;

    /**
     * ID to hand to certain types of methods (e.g. for when retrieving one record).
     *
     * @var string|int
     * @see $method
     **/
    private $id = null;

    /**
     * Method of class we will call.
     *
     * @var string
     * @see $class
     **/
    private $method;
} // END class Request