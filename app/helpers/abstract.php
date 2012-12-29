<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of h-abstract
 *
 * @author Anthony.Humes
 */
abstract class SMW_Helpers_Abstract {
    private $data;
    public function __construct($data) {
        $this->data = $data;
        $this->class_name = $this->getClassName();
    }
    public function load( $data ) {
        $helper = new $this->class_name($data);
        return $helper;
    }
    /**
     * Returns the name of the class which resides in this model
     * 
     * @return string The name of the class 
     */
    public function getClassName() {
        return get_class( $this );
    }
    public function __set($name, $value) {
        $this->data[$name] = $value;
    }
    public function __get( $name ) {
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }
        
        $trace = debug_backtrace();
        trigger_error(
            'Undefined property via __get(): ' . $name .
            ' in ' . $trace[0]['file'] .
            ' on line ' . $trace[0]['line'],
            E_USER_NOTICE);
        return null;
    }
}
