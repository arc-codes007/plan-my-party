<?php

return [
    "package_types" => array('Birthday','Anniversary','Wedding','Kitty', 'Promotion', 'Retirement','Others'),
    "venue_types" => array('Indoor','Outdoor','Rooftop','Banquet','Garden','Hall','Bar','Stadium','Resort'),
    "party_statuses" => array(
        'draft' => "Draft",
        'planned' => "Planned",
        'celebrated' => "Celebrated",
    ),
    "party_status_class" => array(
        'Draft' => 'bg-warning',
        'Planned' => 'bg-primary',
        'Celebrated' => 'bg-success',
    )
];