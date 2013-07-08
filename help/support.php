<?php
/**
 * Support Reference Help Tab Content
 */

##################################
/* Removed by Erik

$mayflower_github_data_issues_open = mayflower_get_github_api_data( 'issues', 'open' );
$mayflower_github_data_roadmap = mayflower_get_github_api_data( 'issues', 'open', '*', true );
$mayflower_github_data_issues_closed = mayflower_get_github_api_data( 'issues', 'closed' );
$mayflower_github_data_commits = mayflower_get_github_api_data( 'commits' );

End Removal */
##################################


$tabtext = '';
$tabtext .= '<h2>' . __( 'Support options and links for Oenology', 'mayflower' ) . '</h2>';

// Support Options
$tabtext .= '<h3><span>' . __( 'Oenology Support Options', 'mayflower' ) . '</span></h3>';
$tabtext .= '<div class="postbox"><div class="inside">';
$tabtext .= '<p>' . __( 'For Oenology support, please use one of the below options. I will do my best to fix all bug reports as quickly as possible, and to respond to all support queries.', 'mayflower' ) . '</p>';
$tabtext .= '<h4>' . __( 'Bug Reports and Feature Requests:', 'mayflower' ) . '</h4>';
$tabtext .= '<p>';
$tabtext .= '<a class="oenology-support-submit" target="_blank" href="https://github.com/chipbennett/oenology/issues/new">';
$tabtext .= __( 'Submit a bug report or feature request', 'mayflower' );
$tabtext .= '</a><br />';
$tabtext .= '<span style="font-size:11px;"><em>' . __( 'Note: requires a (free) GitHub account.', 'mayflower' ) . '</span></em>';
$tabtext .= '</p>';
$tabtext .= '<p>' . __( 'Use this option for the following types of issues:', 'mayflower' ) . '</p>';
$tabtext .= '<ol style="font-size:11px;">';
$tabtext .= '<li style="line-height:1em;">' . __( 'Theme functionality, style, or design is broken', 'mayflower' ) . '</li>';
$tabtext .= '<li style="line-height:1em;">' . __( 'Theme functionality, style, or design doesn\'t work right, or as expected', 'mayflower' ) . '</li>';
$tabtext .= '<li style="line-height:1em;">' . __( 'Theme functionality, style, or design could be improved', 'mayflower' ) . '</li>';
$tabtext .= '<li style="line-height:1em;">' . __( 'Theme functionality or feature could be added', 'mayflower' ) . '</li>';
$tabtext .= '</ol>';
$tabtext .= '<h4 style="padding-top:10px;">' . __( 'General Support Requests:', 'mayflower' ) . '</h4>';
$tabtext .= '<p>';
$tabtext .= '<a class="oenology-support-submit" target="_blank" href="http://wordpress.org/tags/oenology?forum_id=5#postform">';
$tabtext .= __( 'Submit a general support request', 'mayflower' );
$tabtext .= '</a><br />';
$tabtext .= '<span style="font-size:11px;"><em>' . __( 'Note: requires a (free) WordPress.org account.', 'mayflower' ) . '</span></em>';
$tabtext .= '</p>';
$tabtext .= '<p>' . __( 'Use this option for the following types of issues:', 'mayflower' ) . '</p>';
$tabtext .= '<ol style="font-size:11px;">';
$tabtext .= '<li style="line-height:1em;">' . __( 'Help with using the Theme', 'mayflower' ) . '</li>';
$tabtext .= '<li style="line-height:1em;">' . __( 'Help with Theme options', 'mayflower' ) . '</li>';
$tabtext .= '<li style="line-height:1em;">' . __( 'Help with modifying the Theme', 'mayflower' ) . '</li>';
$tabtext .= '</ol>';
$tabtext .= '</div></div>';

// Open Bug Reports
$tabtext .= '<h3>';
$tabtext .= '<span>' . __( 'Open Oenology Bug Reports', 'mayflower' ) . '</span>';
$tabtext .= ' (<a href="https://github.com/chipbennett/oenology/issues/?sort=created&direction=asc&state=open">' . __( 'See All', 'mayflower' ) . '</a>)';
$tabtext .= '</h3>';
$tabtext .= '<div class="postbox"><div class="inside">';
//$tabtext .= '<div class="text-widget">' . $mayflower_github_data_issues_open . '</div>';
$tabtext .= '</div></div>';

// Latest Support Forum Topics
$tabtext .= '<h3>';
$tabtext .= '<span>' . __( 'Latest Oenology Support Topics', 'mayflower' ) . '</span> ';
$tabtext .= ' (<a href="http://wordpress.org/tags/oenology">' . __( 'See All', 'mayflower' ) . '</a>)';
$tabtext .= '</h3>';
$tabtext .= '<div class="postbox"><div class="inside">';
$tabtext .= '<div class="rss-widget">' . mayflower_get_support_feed() . '</div>';
$tabtext .= '</div></div>';

// Roadmap
$tabtext .= '<h3>';
$tabtext .= '<span>' . __( 'Oenology Roadmap', 'mayflower' ) . '</span> ';
$tabtext .= '</h3>';
$tabtext .= '<div class="postbox"><div class="inside">';
//$tabtext .= '<div class="text-widget">' . $mayflower_github_data_roadmap . '</div>';
$tabtext .= '</div></div>';

// Bug Reports Closed Since Last Release
$tabtext .= '<h3>';
$tabtext .= '<span>' . __( 'Oenology Bug Reports Closed Since Last Release', 'mayflower' ) . '</span>';
$tabtext .= ' (<a href="https://github.com/chipbennett/oenology/commits/master">' . __( 'See All', 'mayflower' ) . '</a>)';
$tabtext .= '</h3>';
$tabtext .= '<div class="postbox"><div class="inside">';
//$tabtext .= '<div class="text-widget">' . $mayflower_github_data_issues_closed . '</div>';
$tabtext .= '</div></div>';

// Development Commits Since Last Release
$tabtext .= '<h3>';
$tabtext .= '<span>' . __( 'Oenology Development Commits Since Last Release', 'mayflower' ) . '</span>';
$tabtext .= ' (<a href="https://github.com/chipbennett/oenology/issues/?sort=created&direction=asc&state=open">' . __( 'See All', 'mayflower' ) . '</a>)';
$tabtext .= '</h3>';
$tabtext .= '<div class="postbox"><div class="inside">';
//$tabtext .= '<div class="text-widget">' . $mayflower_github_data_commits . '</div>';
$tabtext .= '</div></div>';

return $tabtext;
?>