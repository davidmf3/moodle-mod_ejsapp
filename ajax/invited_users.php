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
 * Ajax update for the EJSApp view.php to see invited Users on EJSApp lab
 *
 * @package    mod_ejsapp
 * @copyright  2012 Luis de la Torre and Ruben Heradio
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 */

require_once(dirname(__FILE__) . '/../../../config.php');
require_once('../locallib.php');

require_login(0, false);

$colsession = required_param('colsession', 'int');

global $PAGE, $DB, $USER, $CFG;

require_once($CFG->libdir.'/tablelib.php');

$PAGE->set_context(context_system::instance());
$PAGE->set_url('/mod/ejsapp/time_left.php');


$collab_session = $DB->get_record('ejsapp_collab_sessions', array('id' => $colsession));

if ($collab_session->master_user == $USER->id){
    $acceptances = $DB->get_records('ejsapp_collab_invitations', array('collaborative_session' => $colsession));


    $context = context_course::instance($collab_session->course);

    $baseurl = new moodle_url('mod/ejsapp/invited_users.php', array(
        'colsession' => $colsession));

    $tablecolumns = array('fullname');
    $tableheaders = array(get_string('invited_users', 'ejsapp'));

    $table = new flexible_table('user-index-invited' . $collab_session->course);

    $table->define_baseurl($baseurl->out());
    $table->define_columns($tablecolumns);
    $table->define_headers($tableheaders);

    $table->no_sorting('fullname');

    $table->set_attribute('cellspacing', '0');
    $table->set_attribute('align','center');
    $table->set_attribute('id', 'invited_users');
    $table->set_attribute('class', 'generaltable generalbox');


    $table->set_control_variables(array(
        TABLE_VAR_SORT      => 'ssort',
        TABLE_VAR_HIDE      => 'shide',
        TABLE_VAR_SHOW      => 'sshow',
        TABLE_VAR_IFIRST    => 'sifirst',
        TABLE_VAR_ILAST     => 'silast',
        TABLE_VAR_PAGE      => 'spage'
    ));

    if (count($acceptances) == 0){
        $table->pagesize(1, 1);
    }else{
        $table->pagesize(count($acceptances), count($acceptances));
    }

    $table->setup();
    $data = array();
    if (count($acceptances) > 0){
        $valid_user=false;
        foreach ($acceptances as $acceptance) {
            $data = array();
            $user = $acceptance->invited_user;

            $sql = "SELECT u.firstname, u.lastname
                      FROM  {user} u 
                     WHERE u.id = :userid";
            $params = [
                'userid' => $user
            ];
            $fullnames = $DB->get_records_sql($sql, $params);

            if ($user > 0){
                $valid_user=true;
            }

            foreach ($fullnames as $fullname){
                if ($piclink = ($USER->id == $user|| has_capability('moodle/user:viewdetails', $context))) {
                    $profilelink = '<strong><a href="' . $CFG->wwwroot . '/user/view.php?id=' . $user . '&amp;course=' . $collab_session->course . '">' . $fullname->firstname . ' ' . $fullname->lastname . '</a></strong>';
                } else {
                    $profilelink = '<strong>' . $fullname->firstname . ' ' . $fullname->lastname . '</strong>';
                }
                $data[]=$profilelink;
                $table->add_data($data);
            }
            if (! $valid_user){
                $noUsers = get_string('no_invited_users', 'ejsapp');
                $profilelink = '<strong>' .$noUsers. '</strong>';
                $data[]=$profilelink;
                $table->add_data($data);
            }
        }
    }else{
        $noUsers = get_string('no_invited_users', 'ejsapp');
        $profilelink = '<strong>' .$noUsers. '</strong>';
        $data[]=$profilelink;
        $table->add_data($data);
    }
    $table->finish_html();
}

