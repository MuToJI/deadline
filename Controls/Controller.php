<?php namespace deadline\Controls;

abstract class Controller
{
    public function __construct()
    {
    }

    /**
     * @param $action
     * @param $method
     * @param $params
     * @return mixed
     */
    public function handle($action, $method, $params)
    {
        $handler = $this->handler($action, $method);
        return $this->{$handler}($params);
    }

    protected function handler($action, $method)
    {
        $method = strtolower($method);
        $action = ucfirst($action);
        $handler = "{$method}{$action}";
        return $handler;
    }
}