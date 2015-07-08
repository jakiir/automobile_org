<?php

if (realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    exit('Please don\'t access this file directly.');
}

if (!class_exists( 'autoMobileCore' )){
    class autoMobileCore {
        public $coreVersion = '1.0';
        public $corePrefix  = 'pc_';

        function __construct(){

        }

         /**
         * Load all class from models directory
         */
        function loadModels( $dir ,$enc=false ){
            $classes = !$enc ? $this->loadDirectory( $dir ) : $this->loadEncDirectory( $dir );
            //foreach( $classes as $class )
                //$this->objects[] = $class;
        }

        /**
         * Load all class from admin directory
         */
        function loadAdmins( $dir ,$enc=false ){
            $classes = $this->loadDirectory( $dir );
            //foreach( $classes as $class )
                //$this->objects[] = $class;
        }

        /**
         * Load all class from admin directory
         */
        function loadHelpers( $dir ){
            $classes = $this->loadClassDirectory( $dir );
            foreach( $classes as $class )
                $this->objects[] = $class;
        }

        /**
         * Include all file from directory
         * Create instence of each class and add return all instance as an array
         */
        function loadClassDirectory( $dir ){
            if (!file_exists($dir)) return;
            foreach (scandir($dir) as $item) {
                if( preg_match( "/.php$/i" , $item ) ) {
                    require_once( $dir . $item );
                    $className = str_replace( ".php", "", $item );
                    $classes[] = new $className;
                }
            }
            return $classes;
        }


        /**
         * Include all file from directory
         * Create instence of each class and add return all instance as an array
         */
        function loadDirectory( $dir ){
            if (!file_exists($dir)) return;
            foreach (scandir($dir) as $item) {
                if( preg_match( "/.php$/i" , $item ) ) {
                    require_once( $dir . $item );
                    $className = str_replace( ".php", "", $item );
                    //$classes[] = new $className;
                }
            }
            return isset( $classes ) ? $classes : false; //$classes;
        }

        function loadEncDirectory( $dir ){
            if (!file_exists($dir)) return;
            foreach (scandir($dir) as $item) {
                if( preg_match( "/.php$/i" , $item ) ) {
                    eval( base64_decode( file_get_contents( $dir . $item ) ) );
                    $className = str_replace( ".php", "", $item );
                    if( class_exists( $className ) ){}
                       // $classes[] = new $className;
                }
            }
            return isset( $classes ) ? $classes : false;
        }



        /**
         * Dynamicaly call any  method from models class
         * by pluginFramework instance
         */
        function __call( $name, $args ){
            if( !is_array($this->objects) ) return;
            foreach($this->objects as $object){
                if(method_exists($object, $name)){
                    $count = count($args);
                    if($count == 0)
                        return $object->$name();
                    elseif($count == 1)
                        return $object->$name($args[0]);
                    elseif($count == 2)
                        return $object->$name($args[0], $args[1]);
                    elseif($count == 3)
                        return $object->$name($args[0], $args[1], $args[2]);
                    elseif($count == 4)
                        return $object->$name($args[0], $args[1], $args[2], $args[3]);
                    elseif($count == 5)
                        return $object->$name($args[0], $args[1], $args[2], $args[3], $args[4]);
                    elseif($count == 6)
                        return $object->$name($args[0], $args[1], $args[2], $args[3], $args[4], $args[5]);
                }
            }
        }
    }


    global $autoMobileCore;
    if( !is_object( $autoMobileCore ) )
        $autoMobileCore = new autoMobileCore;


}