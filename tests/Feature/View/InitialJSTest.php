<?php

namespace Tests\Feature\View;

use App\Models\Site;
use App\View\InitialJS;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class InitialJSTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @var InitialJS
     */
    public $service;

    public function setUp()
    {
        parent::setUp();

        $this->service = app(InitialJS::class);
    }

    /**
     * @test
     * @covers \App\View\InitialJS::pushJSON
     * @covers \App\View\InitialJS::countJSON
     * @covers \App\View\InitialJS::getJSON
     */
    public function push_json_one_time()
    {
        $json = json_encode(['test' => 123]);

        $this->assertEquals(0, $this->service->countJSON());

        $this->service->pushJSON('test', $json);
        $ret = $this->service->getJSON();

        $this->assertEquals(1, $this->service->countJSON());
        $this->assertEquals(['test' => $json], $ret);
    }

    /**
     * @test
     * @covers \App\View\InitialJS::pushJSON
     * @covers \App\View\InitialJS::countJSON
     * @covers \App\View\InitialJS::getJSON
     */
    public function push_json_multi_time()
    {
        $json1 = json_encode(['test' => 123]);
        $json2 = json_encode(['foo' => 'bar']);
        $json3 = json_encode(Site::first()->toArray());

        $this->assertEquals(0, $this->service->countJSON());

        $this->service->pushJSON('test', $json1);
        $this->service->pushJSON('Foo', $json2);
        $this->service->pushJSON('Site', $json3);
        $ret = $this->service->getJSON();

        $this->assertEquals(3, $this->service->countJSON());
        $this->assertEquals([
            'test' => $json1,
            'Foo'  => $json2,
            'Site' => $json3,
        ], $ret);
    }

    /**
     * @test
     * @covers \App\View\InitialJS::pushJSON
     * @covers \App\View\InitialJS::countJSON
     * @covers \App\View\InitialJS::getJSON
     */
    public function push_json_over_write_previous()
    {
        $json = json_encode(['test' => 123]);
        $json2 = json_encode(Site::first()->toArray());

        $this->assertEquals(0, $this->service->countJSON());

        $this->service->pushJSON('test', $json);
        $this->service->pushJSON('test', $json2);
        $ret = $this->service->getJSON();

        $this->assertEquals(1, $this->service->countJSON());
        $this->assertEquals(['test' => $json2], $ret);
    }

    /**
     * @test
     * @covers \App\View\InitialJS::pushVariable
     * @covers \App\View\InitialJS::countVariables
     * @covers \App\View\InitialJS::getVariables
     */
    public function push_variable_one_time()
    {
        $this->assertEquals(0, $this->service->countVariables());

        $this->service->pushVariable('test', 'FooBar');
        $ret = $this->service->getVariables();

        $this->assertEquals(1, $this->service->countVariables());
        $this->assertEquals(['test' => 'FooBar'], $ret);
    }

    /**
     * @test
     * @covers \App\View\InitialJS::pushVariable()
     * @covers \App\View\InitialJS::countVariables()
     * @covers \App\View\InitialJS::getVariables
     */
    public function push_variables_multi_time()
    {
        $this->assertEquals(0, $this->service->countVariables());

        $this->service->pushVariable('test', 1);
        $this->service->pushVariable('Foo', 'bar');
        $this->service->pushVariable('Site', Site::first()->toArray());
        $ret = $this->service->getVariables();

        $this->assertEquals(3, $this->service->countVariables());
        $this->assertEquals([
            'test' => 1,
            'Foo'  => 'bar',
            'Site' => Site::first()->toArray(),
        ], $ret);
    }

    /**
     * @test
     * @covers \App\View\InitialJS::pushVariable
     * @covers \App\View\InitialJS::countVariables
     * @covers \App\View\InitialJS::getVariables
     */
    public function push_variable_over_write_previous()
    {
        $this->assertEquals(0, $this->service->countVariables());

        $this->service->pushVariable('test', 'FooBar');
        $this->service->pushVariable('test', 'over');
        $ret = $this->service->getVariables();

        $this->assertEquals(1, $this->service->countVariables());
        $this->assertEquals(['test' => 'over'], $ret);
    }
}
