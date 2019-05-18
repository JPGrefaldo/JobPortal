<?php

function disable_debugbar()
{
    if (app()->has('debugbar')) {
        app('debugbar')->disable();
    }
}
