<?php

namespace Tests\Support;

trait CustomAsserts
{
    /**
     * @param array $elements
     * @param array|\Illuminate\Support\Collection $array
     */
    protected function assertArrayHas(array $elements, $array): void
    {
        $array = $this->toCollection($array);

        foreach ($elements as $key => $element) {
            $this->assertTrue($array->has($key), "['$key'] does not exist'");
            $subset = $array->get($key);
            if (is_array($subset)) {
                $this->assertArrayHas($element, $array->get($key));
            } else {
                $this->assertEquals($element, $array->get($key));
            }
        }
    }

    /**
     * @param $array
     * @return \Illuminate\Support\Collection
     */
    protected function toCollection($array): \Illuminate\Support\Collection
    {
        if (is_array($array)) {
            return \collect($array);
        }

        return $array;
    }
    
}