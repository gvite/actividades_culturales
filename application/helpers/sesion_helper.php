<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('get_user')) {
    function get_user() {
        @session_start();
        return (isset($_SESSION['username_culturales'])) ? $_SESSION['username_culturales'] : FALSE;
    }
}
if (!function_exists('set_user')) {
    function set_user($user) {
        @session_start();
        $_SESSION['username_culturales'] = $user;
    }

}
if (!function_exists('get_type')) {
    function get_type() {
        @session_start();
        return (isset($_SESSION['usertype_culturales'])) ? $_SESSION['usertype_culturales'] : FALSE;
    }

}
if (!function_exists('set_type')) {
    function set_type($type) {
        @session_start();
        $_SESSION['usertype_culturales'] = floor($type);
    }

}
if (!function_exists('get_type_user')) {
    function get_type_user() {
        @session_start();
        return (isset($_SESSION['typeuser_culturales'])) ? $_SESSION['typeuser_culturales'] : FALSE;
    }
}
if (!function_exists('set_type_user')) {
    function set_type_user($type) {
        @session_start();
        $_SESSION['typeuser_culturales'] = floor($type);
    }

}
if (!function_exists('get_name')) {
    function get_name() {
        @session_start();
        return (isset($_SESSION['usercomplete_culturales'])) ? $_SESSION['usercomplete_culturales'] : FALSE;
    }
}
if (!function_exists('set_name')) {
    function set_name($name) {
        @session_start();
        $_SESSION['usercomplete_culturales'] = $name;
    }
}
if (!function_exists('get_talleres_inscritos')) {
    function get_talleres_inscritos() {
        @session_start();
        return (isset($_SESSION['usertalleres_inscritos_culturales'])) ? $_SESSION['usertalleres_inscritos_culturales'] : 0;
    }
}
if (!function_exists('set_talleres_inscritos')) {
    function set_talleres_inscritos($talleres_inscritos) {
        @session_start();
        $_SESSION['usertalleres_inscritos_culturales'] = $talleres_inscritos;
    }
}
if (!function_exists('get_id')) {
    function get_id() {
        @session_start();
        return (isset($_SESSION['id_user_culturales'])) ? $_SESSION['id_user_culturales'] : FALSE;
    }
}
if (!function_exists('set_id')) {
    function set_id($id) {
        @session_start();
        $_SESSION['id_user_culturales'] = $id;
    }
}
if (!function_exists('clean_session')) {
    function clean_session() {
        @session_start();
        unset($_SESSION['id_user_culturales']);
        unset($_SESSION['usercomplete_culturales']);
        unset($_SESSION['usertype_culturales']);
        unset($_SESSION['username_culturales']);
        session_destroy();
    }
}
?>