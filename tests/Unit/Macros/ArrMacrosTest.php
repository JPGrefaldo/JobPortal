<?php

namespace Tests\Unit\Macros;

use Arr;
use Tests\TestCase;

class ArrMacrosTest extends TestCase
{
    /**
     * @test
     * @covers Arr::recursive_combine
     * @covers \App\Providers\MacrosServiceProvider::array_recursive_combine
     */
    public function one_deep_array_new_element()
    {
        $arrayA = [
            'one' => 1,
            'two' => 2,
        ];

        $arrayB = [
            'three' => 3,
        ];

        $this->assertEquals([
            'one'   => 1,
            'two'   => 2,
            'three' => 3,
        ], Arr::recursive_combine($arrayA, $arrayB));
    }

    /**
     * @test
     * @covers Arr::recursive_combine
     * @covers \App\Providers\MacrosServiceProvider::array_recursive_combine
     */
    public function one_deep_array_replace_element()
    {
        $arrayA = [
            'one' => 1,
            'two' => 2,
        ];

        $arrayB = [
            'two'   => 'replaced',
            'three' => 3,
        ];

        $this->assertEquals([
            'one'   => 1,
            'two'   => 'replaced',
            'three' => 3,
        ], Arr::recursive_combine($arrayA, $arrayB));
    }

    /**
     * @test
     * @covers Arr::recursive_combine
     * @covers \App\Providers\MacrosServiceProvider::array_recursive_combine
     */
    public function multi_deep_array_new_element()
    {
        $arrayA = [
            'one' => [
                'one_1' => [
                    'one_1_1' => [
                        'one' => 1,
                    ],
                ],
            ],
            'two' => 2,
        ];

        $arrayB = [
            'three' => [
                'three_1' => [
                    'three_1_1' => [
                        'three' => 3,
                    ],
                ],
            ],
        ];

        $this->assertEquals([
            'one' => [
                'one_1' => [
                    'one_1_1' => [
                        'one' => 1,
                    ],
                ],
            ],
            'two'   => 2,
            'three' => [
                'three_1' => [
                    'three_1_1' => [
                        'three' => 3,
                    ],
                ],
            ],
        ], Arr::recursive_combine($arrayA, $arrayB));
    }

    /**
     * @test
     * @covers Arr::recursive_combine
     * @covers \App\Providers\MacrosServiceProvider::array_recursive_combine
     */
    public function multi_deep_array_replace_element()
    {
        $arrayA = [
            'one' => [
                'one_1' => [
                    'one_1_1' => [
                        'one' => 1,
                    ],
                ],
            ],
            'two' => 2,
        ];

        $arrayB = [
            'one' => [
                'one_1' => [
                    'one_1_1' => [
                        'one' => 'replaced',
                    ],
                ],
            ],
        ];

        $this->assertEquals([
            'one' => [
                'one_1' => [
                    'one_1_1' => [
                        'one' => 'replaced',
                    ],
                ],
            ],
            'two' => 2,
        ], Arr::recursive_combine($arrayA, $arrayB));
    }

    /**
     * @test
     * @covers Arr::recursive_combine
     * @covers \App\Providers\MacrosServiceProvider::array_recursive_combine
     */
    public function multi_deep_array_same_replace_element()
    {
        $arrayA = [
            'one' => [
                'one_1' => [
                    'one_1_1' => [
                        'one' => 1,
                    ],
                ],
            ],
            'two' => 2,
        ];

        $arrayB = [
            'one' => [
                'one_1' => [
                    'one_1_1' => [
                        'one' => 'replaced',
                    ],
                ],
            ],
            'two' => 2,
        ];

        $this->assertEquals([
            'one' => [
                'one_1' => [
                    'one_1_1' => [
                        'one' => 'replaced',
                    ],
                ],
            ],
            'two' => 2,
        ], Arr::recursive_combine($arrayA, $arrayB));
    }

    /**
     * @test
     * @covers Arr::recursive_combine
     * @covers \App\Providers\MacrosServiceProvider::array_recursive_combine
     */
    public function multi_deep_array_empty_a()
    {
        $arrayA = [];

        $arrayB = [
            'one' => [
                'one_1' => [
                    'one_1_1' => [
                        'one' => 1,
                    ],
                ],
            ],
            'two' => 2,
        ];

        $this->assertEquals([
            'one' => [
                'one_1' => [
                    'one_1_1' => [
                        'one' => 1,
                    ],
                ],
            ],
            'two' => 2,
        ], Arr::recursive_combine($arrayA, $arrayB));
    }

    /**
     * @test
     * @covers Arr::recursive_combine
     * @covers \App\Providers\MacrosServiceProvider::array_recursive_combine
     */
    public function multi_deep_array_empty_b()
    {
        $arrayA = [
            'one' => [
                'one_1' => [
                    'one_1_1' => [
                        'one' => 1,
                    ],
                ],
            ],
            'two' => 2,
        ];

        $arrayB = [];

        $this->assertEquals([
            'one' => [
                'one_1' => [
                    'one_1_1' => [
                        'one' => 1,
                    ],
                ],
            ],
            'two' => 2,
        ], Arr::recursive_combine($arrayA, $arrayB));
    }
}
