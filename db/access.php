<?php
$capabilities = array(
    'local/inlinetrainer_experiments:experiment_user' => array(
        'captype' => 'read',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes' => array(
        )
    ), 'local/inlinetrainer_experiments:experiment_researcher' => array(
        'captype' => 'read',
        'contextlevel' => CONTEXT_SYSTEM,
        'riskbitmask' => RISK_PERSONAL,
    )
);