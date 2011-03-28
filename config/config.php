<?php

define(SQL_ENGINE,'mysql');
define(HOST,'127.0.0.1');
define(DB_USER,'root');
define(DB_PASSWORD,'b050108944');
define(DB_NAME,'blog');


define(DEBUG_MODE,2);

define(CHARSET,'UTF8');
define(START_TITLE,'.: My Blog');
define(END_TITLE,':.');

define(ADMIN_PASSWORD,'sirius');

$default['controller'] = 'Posts';
$default['action'] = 'index';