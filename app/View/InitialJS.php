<?php

namespace App\View;


class InitialJS
{
    /**
     * @var array
     */
    private $json = [];
    /**
     * @var array
     */
    private $variables = [];

    public function any()
    {
        return (bool) ($this->countVariables() + $this->countJSON());
    }

    /**
     * @return int
     */
    public function countJSON(): int
    {
        return count($this->json);
    }

    /**
     * @param $variableName
     * @param $json
     */
    public function pushJson($variableName, $json)
    {
        $this->json[$variableName] = $json;
    }

    /**
     * @return array
     */
    public function getJson(): array
    {
        return $this->json;
    }

    /**
     * @return int
     */
    public function countVariables(): int
    {
        return count($this->variables);
    }

    /**
     * @param $variableName
     * @param $data
     */
    public function pushVariable($variableName, $data)
    {
        $this->variables[$variableName] = $data;
    }

    /**
     * @return array
     */
    public function getVariables(): array
    {
        return $this->variables;
    }
}