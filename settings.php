<?php


if ( $hassiteconfig ){

    // Create the new settings page
    // - in a local plugin this is not defined as standard, so normal $settings->methods will throw an error as
    // $settings will be NULL
    $settings = new admin_settingpage( 'local_inlinetrainer_experiments', 'Inline Trainer Experiments' );

    // Create
    $ADMIN->add( 'localplugins', $settings );


    $username_base = new admin_setting_configtext(

    // This is the reference you will use to your configuration
        'local_inlinetrainer_experiments_username_base',

        // This is the friendly title for the config, which will be displayed
        'Experiment Account Username Base',

        // This is helper text for this config field
        'This is the base used to create experiment users. A number is automatically appended.',

        // This is the default value
        'test_user',

        // This is the type of Parameter this config is
        PARAM_TEXT

    );

    $settings->add( $username_base );

    $password = new admin_setting_configtext(

    // This is the reference you will use to your configuration
        'local_inlinetrainer_experiments_password',

        // This is the friendly title for the config, which will be displayed
        'Experiment Account Password',

        // This is helper text for this config field
        'This is the default password for all experiment accounts',

        // This is the default value
        'Test123!',

        // This is the type of Parameter this config is
        PARAM_TEXT

    );

    $settings->add( $password );

    $role_list = role_get_names(null);

    $role_options=array();

    foreach($role_list as $role){
        $role_options[$role->id]=$role->localname;
    }

    $system_roles = new admin_setting_configmulticheckbox(
      'local_inlinetrainer_experiment_user_roles_system',
      'Experiment System User Roles',
      'These roles will be assigned to newly-created experimental users at the system level',
      '',
      $role_options
    );

    $settings->add($system_roles);


    $course_fullname = new admin_setting_configtext(

    // This is the reference you will use to your configuration
        'local_inlinetrainer_experiments_course_fullname',

        // This is the friendly title for the config, which will be displayed
        'Experiment Course Full Name',

        // This is helper text for this config field
        'This is the full name given to experimental courses',

        // This is the default value
        'Test Course',

        // This is the type of Parameter this config is
        PARAM_TEXT

    );

    $settings->add( $course_fullname );

    $course_shortname = new admin_setting_configtext(

    // This is the reference you will use to your configuration
        'local_inlinetrainer_experiments_course_shortname',

        // This is the friendly title for the config, which will be displayed
        'Experiment Course Short Name Base',

        // This is helper text for this config field
        'This is the base used to create experiment course shortnames. A number is automatically appended.',

        // This is the default value
        'TEST',

        // This is the type of Parameter this config is
        PARAM_TEXT

    );

    $settings->add( $course_shortname );

    $category_list = coursecat::make_categories_list();



    $course_category = new admin_setting_configselect(
      'local_inlinetrainer_experiments_course_category',
      'Experiment Course Category',
      'This is the category assigned to experimental courses',
      1,
      $category_list
    );

    $settings->add($course_category);


    $course_roles = new admin_setting_configmulticheckbox(
        'local_inlinetrainer_experiment_user_roles_course',
        'Experiment Course User Roles',
        'These roles will be assigned to newly-created experimental users at the course level',
        '',
        $role_options
    );

    $settings->add($course_roles);

    $course_sections = new admin_setting_configtextarea(
        'local_inlinetrainer_experiment_default_course_sections',
        'Experiment Default Course Sections',
        'These sections will automatically be created within the course. One per line.',
        ''
    );

    $settings->add($course_sections);

    $survey_link = new admin_setting_configtext(
        'local_inlinetrainer_experiment_survey_url',
        'Survey URL',
        'Use #{id} where you would like the user id to go',
        ''
    );

    $settings->add($survey_link);

    $num_sessions = new admin_setting_configtext(
        'local_inlinetrainer_experiment_num_sessions',
        'Number of sessions',
        'Number of sessions (courses) to create',
        '1'
    );

    $settings->add($num_sessions);

}