<?php

require_once('../../config.php');

require_login();

require_capability('local/inlinetrainer_experiments:experiment_researcher', context_system::instance());

$PAGE->set_context(context_system::instance());

$PAGE->set_pagelayout('standard');

$PAGE->set_url('/local/inlinetrainer_experiments/index.php');
$PAGE->set_title('Inline Trainer Experiments');
$PAGE->set_heading('Inline Trainer Experiments');

$form = new local_inlinetrainer_experiments_experiment_form();

if($new_experiment = $form->get_data()){
    local_inlinetrainer_experiments_experiment::create($new_experiment->firstname,$new_experiment->lastname);
}

echo $OUTPUT->header();

$experiments = local_inlinetrainer_experiments_experiment::get_experiments();






$table = new html_table();
$table->head = array(
    'Name',
    'Username',
    'Course',
    'Log'
);
foreach($experiments as $experiment){
    $log_link = new moodle_url('/report/log/index.php',array('chooselog'=>1,'user'=>$experiment->user->id));
    $course_link = new moodle_url('/course/view.php',array('id'=>$experiment->course->id));
    $table->data[] = array(
        $experiment->user->firstname." ".$experiment->user->lastname,
        $experiment->user->username,
        "<a href='$course_link'>{$experiment->course->shortname}</a>",
        "<a href='$log_link'>View</a>"
    );
}

echo html_writer::table($table);

echo $OUTPUT->heading('New experiment');

$form->display();



echo $OUTPUT->footer();