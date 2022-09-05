<?php
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    $link = "https";
} else {
    $link = "http";
}
$link .= "://" . $_SERVER['HTTP_HOST'];
return [
    'project_name' => 'Health Facility Punjab',
    'project_shortname' => 'HFP',
    'asset_path' => $link . '/dashboards_public_asset/laravel',
]

?>
