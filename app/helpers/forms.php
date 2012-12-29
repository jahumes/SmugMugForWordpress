<?php

/**
 * SMW_Helpers_Forms - Controls the admin settings page
 * 
 * @package SMW
 * @subpackage Helpers
 * @author  Anthony Humes
 **/
class SMW_Helpers_Forms extends SMW_Helpers_Abstract {
    public $post;
    public $meta_boxes;
    public $args;
    public $value;
    public $url;
    public function __construct($args) {
        $this->id = $args['id'] ? $args['id'] : '';
        $this->class = $args['class'] ? $args['class'] : '';
        $this->type = $args['type'] ? $args['type'] : 'ajax';
        $this->action = $args['action'];
        $this->current = $args['current'];
        $this->two_columns = $args['two_columns'] ? $args['two_columns'] : true;
    }
    public function load($args) {
        $this->id = $args['id'] ? $args['id'] : '';
        $this->class = $args['class'] ? $args['class'] : '';
        $this->type = $args['type'] ? $args['type'] : 'ajax';
        $this->action = $args['action'];
        $this->current = $args['current'];
        $this->two_columns = $args['two_columns'] ? $args['two_columns'] : true;
        
        return $this;
    }
    /**
     * Creates the form table
     * 
     * @access  public
     * @param   array $meta_boxes The fields to be used in the create form block
     * @param   int $columns Number of columns for the meta boxes
     * @param   bool $is_post If true, on a post page
     * @return  void
     */
    function createFormTable() {
        SMW::getBlock('helpers/forms/form-table');
    }
    /**
     * Generates the table to be used
     * 
     * @access  public
     * @param   array $meta The fields to be used in the create form block
     * @param   int $columns Number of columns for the meta boxes
     * @param   bool $is_post If true, on a post page
     * @return  void
     */
    function generateTable($field) {
        
        /*if($is_post) {
            $value = stripslashes( get_post_meta( $this->post->ID, $meta['name'], true ) );
            if(!$value) {
                $value = $meta['default_value'];
            }
            
        } else {
            $value = stripslashes( get_option( $meta['name']) );
        }*/
        if(!is_array($field['id'])) $field['current'] = $this->current->$field['id'];
        return $this->smwFieldCreation( $field, $value );
    }
    public function formStart() {
        SMW::getBlock('helpers/forms/form-start');
    }
    public function formEnd( $loading = 'Loading...' ) {
        $this->loading_text = $loading;
        SMW::getBlock('helpers/forms/form-end');
    }
    public function arrayToValues( $array, $name, $value, $default = 'Please Select' ) {
        $return['default'] = array('name' => $default, 'value' => '');
        foreach($array as $key => $array_value) {
            $return[$key]['name'] = $array_value[$name];
            $return[$key]['value'] = $array_value[$value];
        }
        return $return;
    }
    public function field( $type, $label, $args ) {
        if(is_array($args['name'])) {
            $this->name = $args['name'][0] ? $args['name'][0] : $args['id'];
            $this->field_id = $args['id'] ? $args['id'] : $args['name'][0];
            $this->value = isset($this->current[$args['name'][0]][$args['name'][1]]) ? $this->current[$args['name'][0]][$args['name'][1]] : NULL;
        } else {
            $this->name = $args['name'] ? $args['name'] : $args['id'];
            $this->field_id = $args['id'] ? $args['id'] : $args['name'];
            $this->value = $this->current[$this->name] ? $this->current[$this->name] : NULL;
        }
        if($this->value == NULL && $args['value']) {
            $this->value = $args['value'];
        }
        $this->label = $label;
        unset($args['name']);
        unset($args['id']);
        $this->options = $args;
        SMW::getBlock('helpers/forms/input-' . $type);
    }
    /**
     * Generates a field
     * 
     * @access  public
     * @param   array $args Holds the values for the form
     * @param   bool $value
     * @return  void
     */
    public function smwFieldCreation( $args = false, $value = false ) {
        $this->args = $args;
        
        SMW::getBlock('helpers/forms/input-' . $args['type']);
    }
}