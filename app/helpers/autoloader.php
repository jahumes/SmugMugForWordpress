<?php
/**
 * SMW_Helpers_Autoloader - Controls the admin settings page
 * 
 * @package SMW
 * @subpackage Helpers
 * @author  Anthony Humes
 **/
class SMW_Helpers_Autoloader
{
    /**
     * Registers the autoload function
     * 
     * @access  public
     * @return  array
     */
    public static function registerAutoload()
    {
        return spl_autoload_register(array(__CLASS__, 'includeClass'));
    }
    /**
     * Registers the autoload unregister function
     * 
     * @access  public
     * @return  array
     */
    public static function unregisterAutoload()
    {
        return spl_autoload_unregister(array(__CLASS__, 'includeClass'));
    }
    /**
     * Auto includes the class based off of the name
     * 
     * @access  public
     * @param   string $class Takes the class name and using it requires the class file
     * @example 'SMW_Controllers_Admin_Overview' calls the function require_once(SMW_CLASS_DIR . "/controllers/admin/overview.php")
     * @return  array
     */
    public static function includeClass( $class )
    {
        
        if( $class == 'SMW_phpSmug' ) {
            $path = SMW_CLASSES_DIR . $class;
            require_once("{$path}.php");
        } elseif( !class_exists( $class ) ) {
            $pos = strpos( $class, 'SMW_' );
            if( $pos === false ) {
                
            } else {
                $path = str_replace( 'SMW_', '', $class );
                $classes = explode('_',$path);
                foreach($classes as $class) {
                    preg_match_all('/[A-Z][^A-Z]*/',$class,$new_classes[]);
                }
                $prefix = '';
                foreach($new_classes as $key => $new_class) {
                    $final_classes[] = strtolower(implode('-',$new_class[0]));
                    if($key == (count($new_classes) - 1)) {
                        //$prefix .= strtolower(substr($new_class[0][0], 0, 2));
                    } elseif($key == 0) {
                        $prefix .= strtolower(substr($new_class[0][0], 0, 1));
                    } elseif($key == (count($new_classes) - 2)) {
                        $prefix .= strtolower(substr($new_class[0][0], 0, 2));
                    } else {
                        $prefix .= strtolower(substr($new_class[0][0], 0, 1));
                    }
                }
                $last_item = $prefix . '-' . array_pop($final_classes);
                array_push($final_classes,$last_item);
                $path = implode('/',$final_classes);
                $path = SMW_CLASSES_DIR . $path;
                require_once("{$path}.php");
            }
        }
    }
}

