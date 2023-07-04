<?php

function container(): \Illuminate\Container\Container
{
    return \app\core\Application::$app->container;
}

