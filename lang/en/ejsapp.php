<?php
// This file is part of the Moodle module "EJSApp"
//
// EJSApp is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// EJSApp is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle. If not, see <http://www.gnu.org/licenses/>.
//
// EJSApp has been developed by:
// - Luis de la Torre: ldelatorre@dia.uned.es
// - Ruben Heradio: rheradio@issi.uned.es
//
// at the Computer Science and Automatic Control, Spanish Open University
// (UNED), Madrid, Spain.

/**
 * English strings for ejsapp
 *
 * @package    mod_ejsapp
 * @copyright  2012 Luis de la Torre and Ruben Heradio
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['modulename'] = 'EJSApp';
$string['modulenameplural'] = 'EJSApps';
$string['modulename_help'] = 'The EJSApp activity module enables teachers to add javascript applications and java applets created with Easy Java/Javascript Simulations (EjsS) into their Moodle courses.

Javascript applications will be embedded into the Moodle courses and the Java applets will be launched as desktop applications, using the JNLP protocol. If the EjsS application was compiled using the "Add language facilities" option in EjsS, the lab embedded into Moodle with the EJSApp activity will automatically set its language to the one selected by the user in Moodle, if possible.

When used along with the EJSApp File Browser block, and if the applications have been prepared in EjsS for this purpose, students can save the state of the EjsS application, as well as text or image files. The information of the states is saved into a .json file which is stored in the EJSApp File Browser block. These states can be recovered by an EjsS application clicking on the .json files in the EJSApp File Browser block.

When used along with the EJSApp Collab Sessions block, Moodle users can work with the same EjsS application in a synchronous way, meaning the application will show the same state for all the users in the collaborative session. Thanks to this block, users can create sessions, invite other users and work together with the same EJSApp activity.

When used along with the Remlab Manager block, the EJSApp activities that consist on remote labs can benefit from the numerous management options featured by such block.

When used along with the EJSApp Booking System activity, experimentation sessions with the EJSApp activities that consist of remote labs are scheduled from this module.';
$string['ejsappname'] = 'Lab name';
$string['ejsappname_help'] = 'Name that will appear in the course for this laboratory';
$string['ejsapp'] = 'EJSApp';
$string['pluginadministration'] = 'EJSApp administration';
$string['pluginname'] = 'EJSApp';
$string['noejsapps'] = 'There are no EJSApp activities in this course';

$string['state_load_msg'] = 'The lab state is going to be updated';
$string['state_fail_msg'] = 'Error while trying to load the state';

$string['controller_load_msg'] = 'A controller for this lab is going to be loaded';
$string['controller_fail_msg'] = 'Error while trying to load the controller';

$string['recording_load_msg'] = 'A recording with this lab is going to be run';
$string['recording_fail_msg'] = 'Error while trying to run the recording';

$string['more_text'] = 'Optional text after the EjsS lab';

$string['jar_file'] = '.jar or .zip file that encapsulates the  EjsS lab';

$string['appletfile'] = 'Easy Java(script) Simulation';
$string['appletfile_required'] = 'A .jar or a .zip file must be selected';
$string['appletfile_help'] = 'Select the .jar or .zip file that encapsulates the Easy Java/Javascript Simulations (EjsS) application. The official website of EjsS is http://fem.um.es/Ejs/';

$string['appwording'] = 'Wording';

$string['css_style'] = 'CSS stylesheet for a Javascript application';

$string['css_rules'] = 'Create your own css rules to change the visual aspect of the javascript application';
$string['css_rules_help'] = 'Important! Write each selector and the beginning of its declaration (the opening curly bracket) in the same line.';

$string['state_file'] = '.json file with the state to be read when this EjsS lab loads';

$string['statefile'] = 'Easy Java(script) Simulation State';
$string['statefile_help'] = 'Select the .json file with the state the EjsS Javascript application should load.';

$string['recording_file'] = '.rec file with the recording to be run when this EjsS lab loads';

$string['recordingfile'] = 'Easy Java(script) Simulations Recording';
$string['recordingfile_help'] = 'Select the .rec file with the interaction recording the EjsS application should run.';

$string['personalize_vars'] = 'Personalize variables of the EjsS lab';

$string['use_personalized_vars'] = 'Personalize variables for each user?';
$string['use_personalized_vars_help'] = 'Select yes if you know the name of some of the variables in the EjsS model and you want them to adquire different values for each of the users accessing this application.';

$string['var_name'] = 'Name {no}';
$string['var_name_help'] = 'Name of the variable in the EjsS model.';

$string['var_type'] = 'Type {no}';
$string['var_type_help'] = 'Type of the variable in the EjsS model.';

$string['min_value'] = 'Minimum value {no}';
$string['min_value_help'] = 'Minimum value allowed for the variable.';

$string['max_value'] = 'Maximum value {no}';
$string['max_value_help'] = 'Maximum value allowed for the variable.';

$string['vars_required'] = 'WARNING: If you want to use personalized variables, you must specify at least one.';
$string['vars_incorrect_type'] = 'WARNING: The specified type and values for this variable does not correspond to each other.';

$string['blockly_config'] = 'Configure use of Blockly';

$string['use_blockly'] = 'Enable using Blockly';
$string['use_blockly_help'] = 'When using this option, the EJSApp activity will display a space for programming in Blockly. The programs created with Blockly will be able to interact with the virtual or remote lab.';
$string['charts_blockly'] = 'Mostrar bloques de gr&aacute;ficas';
$string['events_blockly'] = 'Mostrar bloques de eventos';
$string['controller_blockly'] = 'Mostrar bloques de controlador';
$string['blocklyfile'] = 'Initial program';
$string['blocklyfile_help'] = 'You can select a .blk file that specifies which blockly programs should be initially loaded.';

$string['rem_lab_conf'] = 'Remote lab configuration';

$string['is_rem_lab'] = 'Remote experimental system?';
$string['is_rem_lab_help'] = 'If this EJSApp connects to real remote resources AND you want the EJSApp Booking System to manage their access, select "yes". Otherwise, select "no". NOTE: You need the Remlab Manager block for this option to be available.';

$string['practiceintro'] = 'Practice identifier';
$string['practiceintro_help'] = 'The identifier of the practice you want to use with this experimental system. NOTE: You need the Remlab Manager block for this option to be available.';
$string['practiceintro_required'] = 'WARNING: If you want to configure this activity as a remote lab, you need to specify a practice identifier previously defined in the Remlab Manager block.';

$string['record_interactions'] = 'Record user interactions';
$string['record_interactions_help'] = 'When this option is marked as \'yes\', Moodle will store the user interactions with the EjsS lab: pressed buttons, changes of parameters, and so on. Enable it if you want to apply learning analytics.';
$string['record_mouse_events'] = 'Record mouse events';
$string['record_mouse_events_help'] = 'Recording mouse movement events will generate larger sets of data. You may want to leave this option as \'no\' if you do not find this information useful for performing learning analysis in this lab.';

$string['file_error'] = "Can't open file from the server";
$string['manifest_error'] = " > Can't find or open manifest .mf. Check the file you uploaded.";
$string['EJS_version'] = "WARNING: The applet file was not generated with EjsS 4.37 (build 121201), or higher. Recompile it with a newer version of EjsS.";
$string['EJS_codebase'] = "WARNING: The manifest in the applet you uploaded does not specified this Moodle server in the 'codebase' parameter, so it has not been signed.";

$string['inactive_lab'] = 'The remote lab is inactive at this moment.';
$string['no_booking'] = 'You do not have an active booking for this lab.';
$string['collab_access'] = 'This is a collaborative session.';
$string['check_bookings'] = 'Check your active bookings with the booking system.';
$string['lab_in_use'] = 'The lab is currently being used or rebooted. Try again later.';
$string['booked_lab'] = 'This lab has been booked for this hour in a different course. Try again later.';

$string['ejsapp_error'] = 'The EJSApp activity you are trying to access does not exist.';

$string['personal_vars_button'] = 'View personalized variables';

//DMF-I
$string['time_left'] = 'Time left';
$string['connected_users'] = 'Connected users';
$string['no_connected_users'] = 'No connected users';
$string['invited_users'] = 'Invited users';
$string['no_invited_users'] = 'No invited users';
//DMF-F

// Strings in lib.php.
$string['deletedlogs'] = 'Delete all log entries';
$string['deletedlegacylogs'] = 'Delete all legacy log entries';
$string['deletedrecords'] = 'Delete all user actions recorded in ejsapp activities';
$string['deletedpersonalvars'] = 'Delete all user personalized variables';
$string['deletedgrades'] = 'Delete all grades of ejsapp activities';

// Strings in personalized_vars_values.php.
$string['personalVars_pageTitle'] = 'Values of the personalized variables';
$string['users_ejsapp_selection'] = 'Select the users and the EJSApp activity';
$string['ejsapp_activity_selection'] = 'EJSApp activity selection';
$string['variable_name'] = 'Variable';
$string['variable_value'] = 'Value';
$string['export_all_data'] = 'Export data for all EJSApp activities in this course';
$string['export_this_data'] = 'Export data for this EJSAppp activity';
$string['no_ejsapps'] = 'The selected EJSApp activity doesn\'t have personalized variables';
$string['personalized_values'] = 'personalized_values_';

// Strings in leave_or_kick_out.php.
$string['time_is_up'] = 'Your time with the remote lab has ended. If you want to keep working with it, make a new booking and/or refresh this page.';;

// Strings in countdown.php.
$string['seconds'] = 'seconds left.';
$string['refresh'] = 'Try refreshing your window now.';

// Strings in generate_embedding_code.php.
$string['end_message'] = 'End of reproduction';

// Blockly XML configuration file.
$string['xml_logic'] = 'Logic';
$string['xml_loops'] = 'Loops';
$string['xml_maths'] = 'Math';
$string['xml_text'] = 'Text';
$string['xml_lists'] = 'Lists';
$string['xml_variables'] = 'Variables';
$string['xml_functions'] = 'Functions';
$string['xml_lab'] = 'Laboratory';
$string['xml_lab_variables'] = 'Variables';
$string['xml_lab_execution'] = 'Running';
$string['xml_lab_functions'] = 'Functions';
$string['xml_lab_control'] = 'Control';
$string['xml_lab_var_boolean'] = 'Boolean';
$string['xml_lab_var_string'] = 'String';
$string['xml_lab_var_number'] = 'Number';
$string['xml_lab_var_others'] = 'Other';
$string['xml_lab_charts'] = 'Charts';

// Capabilities.
$string['ejsapp:accessremotelabs'] = "Access to all the remote laboratories";
$string['ejsapp:addinstance'] = "Add a new EJSApp activity";
$string['ejsapp:view'] = "View an EJSApp activity";
$string['ejsapp:requestinformation'] = "Request information for third parties plugins";

// Events.
$string['event_viewed'] = "EJSApp activity viewed";
$string['event_working'] = "Working with the EJSApp activity";
$string['event_wait'] = "Waiting for the lab to be free";
$string['event_book'] = "Need to make a booking";
$string['event_collab'] = "Working with the EJSApp activity in collaborative mode";
$string['event_inactive'] = "Lab is inactive";
$string['event_booked'] = "Lab is booked in a different course";
$string['event_left'] = "Left the EJSApp activity";

// Settings.
$string['default_general_set'] = "General settings";
$string['check_activity'] = "Check activity";
$string['check_activity_description'] = "How often the users' activity in EJSApp is checked (s)";
$string['server_id'] = "Site ID in ENLARGE IRS";
$string['server_id_description'] = "ID used for registering this Moodle site in ENLARGE IRS (http://irs.nebsyst.com). Leave it blank if the site is not registered";
$string['default_certificate_set'] = "Trust certificate settings. (Only important if you want to automatically sign the applets uploaded with EJSApp)";
$string['certificate_path'] = "Trust certificate file path";
$string['certificate_path_description'] = "The path in the Moodle server to the trust certificate file to be used for signing the Java applets";
$string['certificate_password'] = "Trust certificate password";
$string['certificate_password_description'] = "The password required for using the trust certificate";
$string['certificate_alias'] = "Trust certificate alias";
$string['certificate_alias_description'] = "The alias given to the trust certificate";

// Privacy
$string['privacy:metadata:ejsapp_records'] = 'Contains users interactions (mouse events) with the EjsS applications.';
$string['privacy:metadata:ejsapp_records:time'] = 'The time at which the action took place.';
$string['privacy:metadata:ejsapp_records:userid'] = 'The ID of the user making the action.';
$string['privacy:metadata:ejsapp_records:ejsappid'] = 'The ID of the EJSApp activity in which the action was made.';
$string['privacy:metadata:ejsapp_records:sessionsid'] = 'The ID of the session.';
$string['privacy:metadata:ejsapp_records:actions'] = 'A description of the actions that were made.';