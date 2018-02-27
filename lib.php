<?php

function local_inlinetrainer_experiments_add_navigation_links($navigation){
    global $trainer_menu_node,$CFG, $USER;

    include('version.php');

    if(has_capability('local/inlinetrainer_experiments:experiment_researcher', context_system::instance(), null, false)){
        $trainer_menu_node = $navigation->add("Inline Trainer Experiments");

        $trainer_menu_node->add('View Experiments',new moodle_url('/local/inlinetrainer_experiments/index.php'));
        $trainer_menu_node->add('Experiment Settings',new moodle_url('/admin/settings.php',array('section'=>'local_inlinetrainer_experiments')));




    }

    $navigation->add('Survey',new moodle_url(str_replace("#{id}",$USER->id,$CFG->local_inlinetrainer_experiment_survey_url)));

}


function local_inlinetrainer_experiments_extend_navigation(global_navigation $navigation) {
    local_inlinetrainer_experiments_add_navigation_links($navigation);
}