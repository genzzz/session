<?php

if(!function_exists('session')){
    /**
     * Get session instance
     * 
     * @return object
     */
    function session()
    {
        return $GLOBALS['genzzz_sess' . session_id()];
    }
}