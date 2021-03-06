<?php

require_once(dirname(__FILE__).'/../../../config.php');
//require_once(dirname(__FILE__)."/../../../user/lib.php");
//require_once(dirname(__FILE__)."/../../../lib/adminlib.php");

class local_inlinetrainer_experiments_experiment
{
    public $user;
    public $course;

    public function __construct($course)
    {
        $this->course = $course;
        $users = get_enrolled_users(context_course::instance($course->id));
        foreach($users as $user){
            $tagged = core_tag_tag::is_item_tagged_with('local_inlinetrainer_experiments','user',$user->id,'experiment_user');
            if($tagged){
                $this->user = $user;
            }
        }

    }

    public static function enroll_user($user, $course){
        global $CFG, $DB;
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

    public static function create($firstname="Test",$lastname="User"){

        global $CFG, $DB;

        $user = local_inlinetrainer_experiments_user::create($firstname,$lastname);

        $sessions = 1;

        if(property_exists($CFG,'local_inlinetrainer_experiment_num_sessions')){
           $sessions = intval($CFG->local_inlinetrainer_experiment_num_sessions);
        }

        for($i=$sessions; $i>0; $i--){
            $course = local_inlinetrainer_experiments_course::create($i);

            $coursecontext = context_course::instance($course->id);

            self::enroll_user($user, $course);
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

    static function get_courses(){
        $tag = core_tag_tag::get_by_name(0,'experiment_course');
        if($tag){
            $users = $tag->get_tagged_items('local_inlinetrainer_experiments', 'course');
            return $users;
        }
        return null;
    }

    public static function get_experiments(){

        $courses = array();
        $courses = self::get_courses();

        $experiments = array();

        foreach($courses as $course){
            $experiments[] = new local_inlinetrainer_experiments_experiment($course);
        }

        usort($experiments, function($a,$b){
           $retval = strcasecmp($a->user->username, $b->user->username);
           if($retval == 0){
               $retval = strcasecmp($a->course->shortname, $b->course->shortname);
           }
           return $retval;
        });

        return $experiments;
    }
}