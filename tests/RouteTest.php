<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class RouteTest extends TestCase
{
    /**
     * Testing routes.
     *
     * @return void
     */
    public function testRoutes()
    {
        $this->get('/')
            ->seeJson([]);
    }
}
