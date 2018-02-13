<?php
require_once("$CFG->libdir/formslib.php");


class local_inlinetrainer_experiments_experiment_form extends moodleform {
    //Add elements to form
    public function definition() {
        global $CFG;

        $mform = $this->_form; // Don't forget the underscore!

        $mform->addElement('text', 'firstname', 'First name');
        $mform->addElement('text', 'lastname', 'Last name');

        $mform->addElement('submit','submit','Save');

    }
    //Custom validation should be added here
    function validation($data, $files) {
        return array();
    }
}