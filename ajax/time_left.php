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
 *
 * Ajax update for the EJSApp view.php to see time left clock
 *
 * @package    mod_ejsapp
 * @copyright  2012 Luis de la Torre and Ruben Heradio
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 */

require_once(dirname(__FILE__) . '/../../../config.php');
require_once('../locallib.php');

require_login(0, false);

$ejsappid = required_param('ejsappid', 'int');
$colsession = required_param('colsession', 'int');

global $PAGE, $DB;

$PAGE->set_context(context_system::instance());
$PAGE->set_url('/mod/ejsapp/time_left.php');

$collab_session = $DB->get_record('ejsapp_collab_sessions', array('id' => $colsession));
$ejsapp = $DB->get_record('ejsapp', array('id' => $ejsappid));
$practiceintro = $DB->get_field('block_remlab_manager_exp2prc', 'practiceintro', array('ejsappid' => $ejsappid));
$remlabconf = $DB->get_record('block_remlab_manager_conf', array('practiceintro' => $practiceintro));
$creationtime =date('Y-m-d H:i:00', $collab_session->creationtime);

$slots_duration = $remlabconf->slotsduration;
$durations = array( "0" => 60, "1"=>30, "2"=>15, "3"=>5, "4"=>2 );
$slot_size = $durations[$slots_duration];
$timeduration = $slot_size*60;

$finaltime = new DateTime (date('Y-m-d H:i:s', strtotime("+".$timeduration." second", strtotime($creationtime))));
$currenttime = new DateTime (date('Y-m-d H:i:s'));
if ($finaltime > $currenttime){
    $interval = $finaltime->diff($currenttime);
    echo $interval->format("%H:%I:%S");
}else{
    echo ("00:00:00");
}