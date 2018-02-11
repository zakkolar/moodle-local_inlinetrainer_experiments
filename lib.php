<?php

function local_inlinetrainer_experiments_add_navigation_links($navigation){
    global $trainer_menu_node,$CFG;

    include('version.php');

    if(has_capability('local/inlinetrainer:researchtrainer', context_system::instance(), null, false)){
        $trainer_menu_node = $navigation->add("Inline Trainer Experiments");

        $url_base = "/local/inlinetrainer_experiments";

        $download_new_url = new moodle_url('/local/inlinetrainer/download_data.php');



    }
}


function local_inlinetrainer_experiments_extend_navigation(global_navigation $navigation) {
    local_inlinetrainer_experiments_add_navigation_links($navigation);
}