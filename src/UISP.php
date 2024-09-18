<?php

declare( strict_types = 1 );

namespace Ocolin\UISP;

use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Ocolin\Env\EasyEnv;
use Ocolin\EasySwagger\Swagger;

class UISP
{

    public Swagger $swagger;


/* CONSTRUCTOR
----------------------------------------------------------------------------- */

    /**
     * @param string|null $host     URL of UISP server.
     * @param string|null $base_uri Base URI on UISP server.
     * @param string|null $api_key  UISP API Token.
     * @param string|null $api_file File path to UISP Swagger JSON file.
     * @param bool $local Load local .env file for Environment variables. False if
     *      they are being loaded by project implementing this one.
     * @throws Exception
     */
    public function __construct(
        ?string $host     = null,
        ?string $base_uri = null,
        ?string $api_key  = null,
        ?string $api_file = null,
           bool $local    = false
    ) {
        if( $local === true ) {
            EasyEnv::loadEnv( path: __DIR__ . '/../.env' );
        }
        $host     = $host     ?? $_ENV['UISP_HOST'];
        $base_uri = $base_uri ?? $_ENV['UISP_BASE_URI'];
        $api_key  = $api_key  ?? $_ENV['UISP_API_TOKEN'];
        $api_file = $api_file ?? __DIR__ . '/api.v.2.1.json';

        $this->swagger = new Swagger(
                host: $host,
            api_file: $api_file,
            base_uri: $base_uri,
               token: $api_key,
        );
    }



/* QUERY API PATH
----------------------------------------------------------------------------- */

    /**
     * @throws GuzzleException
     */
    public function path(
        string $path,
        string $method = 'get',
        ?array $data   = null
    ) : object|array
    {
        return $this->swagger->path( path: $path, data: $data );
    }

}