<?php
interface Evil_Singleton {
    private function __construct();
    private function __clone();
    public static function getInstance();
}