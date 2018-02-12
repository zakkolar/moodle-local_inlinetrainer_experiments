<?php

require_once(dirname(__FILE__).'/../../../config.php');
require_once(dirname(__FILE__)."/../../../course/lib.php");

class local_inlinetrainer_experiments_course
{
    private $course;

    public function __construct($course)
    {
        $this->course = $course;
    }

    public static function create(){
        global $CFG, $DB;

        $course = new stdClass();

        $course->fullname=$CFG->local_inlinetrainer_experiments_course_fullname;
        $course->shortname=self::increment_course_code($CFG->local_inlinetrainer_experiments_course_shortname);
        $course->category=$CFG->local_inlinetrainer_experiments_course_category;


        $course = create_course($course);

        if(property_exists($CFG,'local_inlinetrainer_experiment_default_course_sections')){
            $sections = explode("\n",$CFG->local_inlinetrainer_experiment_default_course_sections);
            foreach($sections as $sectionName){

                $section = course_create_section($course);
                $DB->update_record('course_sections',array('id'=>$section->id, 'name'=>$sectionName));
            }
        }





        core_tag_tag::set_item_tags('local_inlinetrainer_experiments', 'course',$course->id, self::get_context(), array('experiment_course'));


        return $course;

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
    static function increment_course_code($course_code) {
        global $DB;

        $course_code = local_inlinetrainer_experiments_helpers::increment_item($course_code);

        if ($DB->record_exists('course', array('shortname'=>$course_code))) {
            return self::increment_course_code($course_code);
        } else {
            return $course_code;
        }
    }
}