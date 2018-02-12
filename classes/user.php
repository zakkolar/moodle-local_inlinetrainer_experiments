<?php

require_once(dirname(__FILE__).'/../../../config.php');
require_once(dirname(__FILE__)."/../../../user/lib.php");
require_once(dirname(__FILE__)."/../../../lib/adminlib.php");

class local_inlinetrainer_experiments_user
{

    public static function create($firstname="Test",$lastname="User"){
        global $CFG, $DB;

        $user = new stdClass();

        $user->username=self::increment_username($CFG->local_inlinetrainer_experiments_username_base);
        $user->password=$CFG->local_inlinetrainer_experiments_password;

        $user->mnethostid = $CFG->mnet_localhost_id;

        $user->confirmed = true;

        $user->email = "root@localhost";
        $user->firstname=$firstname;
        $user->lastname=$lastname;


        $user_id = user_create_user($user);
        core_tag_tag::set_item_tags('local_inlinetrainer_experiments', 'user',$user_id, self::get_context(), array('experiment_user'));



        if(property_exists($CFG,'local_inlinetrainer_experiment_user_roles_system')){
            $roles = explode(",",$CFG->local_inlinetrainer_experiment_user_roles_system);
            foreach($roles as $role){
                role_assign($role, $user_id, self::get_context()->id);
            }
        }

        $user = $DB->get_record('user',array('id'=>$user_id));

        $DB->insert_record('local_inlinetrainer_users', array('user_id'=>$user->id, 'consent'=>1,'open'=>1));

        return $user;

    }


    private static function get_context(){
        return context_system::instance();
    }

    /**
     * Increments username - increments trailing number or adds it if not present.
     * Varifies that the new username does not exist yet
     * Slightly modified from uu_increment_username() in admin/tool/uploaduser/locallib.php
     * @param string $username
     * @return incremented username which does not exist yet
     */
    static function increment_username($username) {
        global $DB, $CFG;

//        if (!preg_match_all('/(.*?)([0-9]+)$/', $username, $matches)) {
//            $username = $username.'1';
//
//        } else {
//            $username = $matches[1][0].($matches[2][0]+1);
//        }

        $username = local_inlinetrainer_experiments_helpers::increment_item($username);

        if ($DB->record_exists('user', array('username'=>$username, 'mnethostid'=>$CFG->mnet_localhost_id))) {
            return self::increment_username($username);
        } else {
            return $username;
        }
    }
}