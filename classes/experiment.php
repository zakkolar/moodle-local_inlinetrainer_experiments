<?php

require_once(dirname(__FILE__).'/../../../config.php');
//require_once(dirname(__FILE__)."/../../../user/lib.php");
//require_once(dirname(__FILE__)."/../../../lib/adminlib.php");

class local_inlinetrainer_experiments_experiment
{
    private $user;
    private $course;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public static function create($firstname="Test",$lastname="User"){

        global $CFG, $DB;

        $user = local_inlinetrainer_experiments_user::create($firstname,$lastname);
        $course = local_inlinetrainer_experiments_course::create();

        $coursecontext = context_course::instance($course->id);

        $enroll = enrol_get_plugin('manual');


        $instances = enrol_get_instances($course->id, true);
        $manualinstance = null;
        foreach ($instances as $instance) {
            if ($instance->name == 'manual') {
                $manualinstance = $instance;
                break;
            }
        }
        if ($manualinstance !== null) {
            $instanceid = $enroll->add_default_instance($course);
            if ($instanceid === null) {
                $instanceid = $enroll->add_instance($course);
            }
            $instance = $DB->get_record('enrol', array('id' => $instanceid));
        }





        if(property_exists($CFG,'local_inlinetrainer_experiment_user_roles_course')){
            $roles = explode(",",$CFG->local_inlinetrainer_experiment_user_roles_course);
            foreach($roles as $role){
                $enroll->enrol_user($instance, $user->id, $role);
            }
        }


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