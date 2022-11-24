<?php
/**
 * The template for displaying all custom post types
 */
 
$acpt = new ZoacresCPT;
$acpt->zoacresCPTCallTemplate( get_post_type() );