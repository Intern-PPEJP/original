<?php

namespace PHPMaker2021\ppejp_web;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * pelatihanmutu controller
 */
class PelatihanmutuController extends ControllerBase
{

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "Pelatihanmutu");
    }
}
