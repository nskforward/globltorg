<?php

/*
 * Model of table USERS 1.0.0
 */

class tablesMySQlModel
 {  
    
  public static function users()
  {
    return array(
        'id'            => NULL,
        'title'         => NULL,
        'name'      => NULL,
        'pass'      => NULL,
        'email'         => NULL,
        'role'          => NULL,
        'date_reg'     => NULL,
        'date_login' => NULL,
        'block'       => NULL
    );
  }
  
  public static function orders()
  {
    return array(
        'id'                => NULL,
        'date_reg'          => NULL,
        'client_name'       => NULL,
        'city_out'          => NULL,
        'city_in'           => NULL,
        'night_count'       => NULL,
        'men_count'         => NULL,
        'air_class_business'=> NULL,
        'date_out'          => NULL,
        'category'          => NULL,
        'type'              => NULL,
        'insurance'         => NULL,
        'wishes'            => NULL,
        'email'             => NULL,
        'tel'               => NULL
    );
  }
  
  public static function pages()
  {
    return array(
        'id'        => NULL,
        'order'     => 1,
        'title'     => NULL,
        'url'       => NULL,
        'content'   => NULL,
        'lt_sb'     => NULL,
        'ld_sb'     => NULL,
        'r_sb'      => NULL,
        'offer'     => 1
    );
  }
  
  public static function continents()
  {
    return array(
        'id'        => NULL,
        'title'     => NULL,
        'url'       => NULL,
        'content'   => NULL,
        'template'  => NULL,
        'lt_sb'     => NULL,
        'ld_sb'     => NULL,
        'r_sb'      => NULL,
        'des_img'   => NULL
    );
  }
  
  public static function places_tour()
  {
    return array(
        'id'        => NULL,
        'title'     => NULL,
        'des'       => NULL,
        'des_img'   => NULL,
        'content'   => NULL,
        'lt_sb'     => NULL,
        'ld_sb'     => NULL,
        'r_sb'      => NULL,
        'url'       => NULL,
        'parent_id' => NULL
    );
  }
  
 }
?>
