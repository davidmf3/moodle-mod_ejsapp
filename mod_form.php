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
// The GNU General Public License is available on <http://www.gnu.org/licenses/>
//
// EJSApp has been developed by:
//  - Luis de la Torre: ldelatorre@dia.uned.es
//	- Ruben Heradio: rheradio@issi.uned.es
//
//  at the Computer Science and Automatic Control, Spanish Open University
//  (UNED), Madrid, Spain

/**
 * EJSApp settings form.
 *
 * @package    mod
 * @subpackage ejsapp
 * @copyright  2012 Luis de la Torre and Ruben Heradio
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();
require_once($CFG->dirroot . '/course/moodleform_mod.php');
require_once($CFG->libdir . '/formslib.php');
require_once($CFG->libdir . '/filelib.php');
require_once($CFG->libdir . '/filestorage/zip_packer.php');
require_once('locallib.php');


/**
 * Class that defines the EJSApp settings form.
 */
class mod_ejsapp_mod_form extends moodleform_mod
{


    /**
     * Called from Moodle to define this form
     *
     * @return void
     */
    function definition()
    {
        global $CFG, $DB;
        $mform = & $this->_form;
        // -------------------------------------------------------------------------------
        // Adding the "general" fieldset, where all the common settings are showed
        $mform->addElement('header', 'general', get_string('general', 'form'));
        // Adding the standard "name" field
        $mform->addElement('text', 'name', get_string('ejsappname', 'ejsapp'), array('size' => '64'));
        if (!empty($CFG->formatstringstriptags)) {
            $mform->setType('name', PARAM_TEXT);
        } else {
            $mform->setType('name', PARAM_NOTAGS);
        }
        $mform->addRule('name', null, 'required', null, 'client');
        $mform->addRule('name', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');
        $mform->addHelpButton('name', 'ejsappname', 'ejsapp');
        // Adding the standard "intro" and "introformat" fields
        if ($CFG->version < 2015051100) $this->add_intro_editor();
        else $this->standard_intro_elements();
        // -------------------------------------------------------------------------------
        // Adding other ejsapp settings by adding more fieldsets
        $mform->addElement('header', 'conf_parameters', get_string('jar_file', 'ejsapp'));

        $mform->addElement('hidden', 'class_file', null);
        $mform->setType('class_file', PARAM_TEXT);
        $mform->setDefault('class_file', 'null');

        $mform->addElement('hidden', 'codebase', null);
        $mform->setType('codebase', PARAM_TEXT);
        $mform->setDefault('codebase', 'null');

        $mform->addElement('hidden', 'mainframe', null);
        $mform->setType('mainframe', PARAM_TEXT);
        $mform->setDefault('mainframe', 'null');

        $mform->addElement('hidden', 'is_collaborative', null);
        $mform->setType('is_collaborative', PARAM_TEXT);
        $mform->setDefault('is_collaborative', 0);

        $mform->addElement('hidden', 'manifest', null);
        $mform->setType('manifest', PARAM_TEXT);
        $mform->setDefault('manifest', '');

        $mform->addElement('hidden', 'applet_name', null);
        $mform->setType('applet_name', PARAM_TEXT);
        $mform->setDefault('applet_name', '');

        $mform->addElement('hidden', 'remlab_manager', null);
        $mform->setType('remlab_manager', PARAM_INT);

        $maxbytes = get_max_upload_file_size($CFG->maxbytes);
        $mform->addElement('filemanager', 'appletfile', get_string('file'), null, array('subdirs' => 0, 'maxbytes' => $maxbytes, 'maxfiles' => 1, 'accepted_types' => array('application/java-archive', 'application/zip')));
        $mform->addRule('appletfile', get_string('appletfile_required', 'ejsapp'), 'required');
        $mform->addHelpButton('appletfile', 'appletfile', 'ejsapp');

        // -------------------------------------------------------------------------------
        // More optional text to be shown after the lab
        $mform->addElement('header', 'more_text', get_string('more_text', 'ejsapp'));

        $mform->addElement('editor', 'ejsappwording', get_string('appwording', 'ejsapp'), null, array('subdirs' => 1, 'maxbytes' => $CFG->maxbytes, 'maxfiles' => -1, 'changeformat' => 1, 'context' => $this->context, 'noclean' => 1, 'trusttext' => 0));
        $mform->setType('appwording', PARAM_RAW);
        // -------------------------------------------------------------------------------
        // Optional Applet display options
        $mform->addElement('header', 'applet_display', get_string('applet_display', 'ejsapp'));

        $mform->addElement('selectyesno', 'applet', get_string('applet', 'ejsapp'));
        $mform->addHelpButton('applet', 'applet', 'ejsapp');

        $mform->addElement('select', 'applet_size_conf', get_string('applet_size_conf','ejsapp'), array(get_string('preserve_applet_size','ejsapp'), get_string('moodle_resize','ejsapp'), get_string('user_resize','ejsapp')));
        $mform->addHelpButton('applet_size_conf', 'applet_size_conf', 'ejsapp');
        $mform->setDefault('applet_size_conf', 0);
        $mform->disabledIf('applet_size_conf', 'applet', 'eq', 0);

        $mform->addElement('selectyesno', 'preserve_aspect_ratio', get_string('preserve_aspect_ratio', 'ejsapp'));
        $mform->addHelpButton('preserve_aspect_ratio', 'preserve_aspect_ratio', 'ejsapp');
        $mform->disabledIf('preserve_aspect_ratio', 'applet_size_conf', 'neq', 2);

        $mform->addElement('text', 'custom_width', get_string('custom_width', 'ejsapp'), array('size' => '3'));
        $mform->setType('custom_width', PARAM_INT);
        $mform->disabledIf('custom_width', 'applet_size_conf', 'neq', 2);

        $mform->addElement('text', 'custom_height', get_string('custom_height', 'ejsapp'), array('size' => '3'));
        $mform->setType('custom_height', PARAM_INT);
        $mform->disabledIf('custom_height', 'applet_size_conf', 'neq', 2);
        $mform->disabledIf('custom_height', 'preserve_aspect_ratio', 'eq', 1);
        // -------------------------------------------------------------------------------
        // Optional Javascript CSS styles
        $mform->addElement('header', 'css_style', get_string('css_style', 'ejsapp'));

        $mform->addElement('textarea', 'css', get_string('css_rules', 'ejsapp'), 'wrap="virtual" rows="8" cols="50"');
        $mform->addHelpButton('css', 'css_rules', 'ejsapp');
        // -------------------------------------------------------------------------------
        // Adding an optional state file to be read when the lab loads
        $mform->addElement('header', 'state_file', get_string('state_file', 'ejsapp'));

        $mform->addElement('filemanager', 'statefile', get_string('file'), null, array('subdirs' => 0, 'maxbytes' => $maxbytes, 'maxfiles' => 1, 'accepted_types' => array('application/xml', 'application/json')));
        $mform->addHelpButton('statefile', 'statefile', 'ejsapp');
        // -------------------------------------------------------------------------------
        // Adding an optional text file with a controller code to be load when the lab is run
        $mform->addElement('header', 'controller_file', get_string('controller_file', 'ejsapp'));

        $mform->addElement('filemanager', 'controllerfile', get_string('file'), null, array('subdirs' => 0, 'maxbytes' => $maxbytes, 'maxfiles' => 1, 'accepted_types' => '.cnt'));
        $mform->addHelpButton('controllerfile', 'controllerfile', 'ejsapp');
        // -------------------------------------------------------------------------------
        // Adding an optional text file with a recording to automatically run it when the lab loads
        $mform->addElement('header', 'recording_file', get_string('recording_file', 'ejsapp'));

        $mform->addElement('filemanager', 'recordingfile', get_string('file'), null, array('subdirs' => 0, 'maxbytes' => $maxbytes, 'maxfiles' => 1, 'accepted_types' => '.rec'));
        $mform->addHelpButton('recordingfile', 'recordingfile', 'ejsapp');
        // -------------------------------------------------------------------------------
        // Personalize variables from the EJS application
        $mform->addElement('header', 'personalize_vars', get_string('personalize_vars', 'ejsapp'));

        $mform->addElement('selectyesno', 'personalvars', get_string('use_personalized_vars', 'ejsapp'));
        $mform->addHelpButton('personalvars', 'use_personalized_vars', 'ejsapp');

        $varsarray = array();
        $varsarray[] = $mform->createElement('text', 'var_name', get_string('var_name', 'ejsapp'));
        $varsarray[] = $mform->createElement('select', 'var_type', get_string('var_type', 'ejsapp'), array('Boolean', 'Integer', 'Double'));
        $varsarray[] = $mform->createElement('text', 'min_value', get_string('min_value', 'ejsapp'), array('size' => '8'));
        $varsarray[] = $mform->createElement('text', 'max_value', get_string('max_value', 'ejsapp'), array('size' => '8'));

        $repeateloptions = array();
        $repeateloptions['var_name']['disabledif'] = array('personalvars', 'eq', 0);
        $repeateloptions['var_name']['type'] = PARAM_TEXT;
        $repeateloptions['var_name']['helpbutton'] = array('var_name', 'ejsapp');
        $repeateloptions['var_type']['disabledif'] = array('personalvars', 'eq', 0);
        $repeateloptions['var_type']['type'] = PARAM_TEXT;
        $repeateloptions['var_type']['helpbutton'] = array('var_type', 'ejsapp');
        $repeateloptions['min_value']['disabledif'] = array('personalvars', 'eq', 0);
        $repeateloptions['min_value']['disabledif'] = array('var_type', 'eq', 0);
        $repeateloptions['min_value']['type'] = PARAM_FLOAT;
        $repeateloptions['min_value']['helpbutton'] = array('min_value', 'ejsapp');
        $repeateloptions['max_value']['disabledif'] = array('personalvars', 'eq', 0);
        $repeateloptions['max_value']['disabledif'] = array('var_type', 'eq', 0);
        $repeateloptions['max_value']['type'] = PARAM_FLOAT;
        $repeateloptions['max_value']['helpbutton'] = array('max_value', 'ejsapp');

        $no = 2;
        if ($this->current->instance) {
            if ($personal_vars = $DB->get_records('ejsapp_personal_vars', array('ejsappid' => $this->current->instance))) {
                $no = count($personal_vars);
            }
        }

        $this->repeat_elements($varsarray, $no, $repeateloptions, 'option_repeats', 'option_add_vars', 2, null, true);
        // -------------------------------------------------------------------------------
        // Use and configuration of Blockly
        $mform->addElement('header', 'blockly_config', get_string('blockly_config', 'ejsapp'));

        $mform->addElement('selectyesno', 'use_blockly', get_string('use_blockly', 'ejsapp'));
        $mform->addHelpButton('use_blockly', 'use_blockly', 'ejsapp');

        $mform->addElement('selectyesno', 'display_logic', get_string('display_logic', 'ejsapp'));
        $mform->disabledIf('display_logic', 'use_blockly', 'eq', 0);

        $mform->addElement('selectyesno', 'display_loops', get_string('display_loops', 'ejsapp'));
        $mform->disabledIf('display_loops', 'use_blockly', 'eq', 0);

        $mform->addElement('selectyesno', 'display_math', get_string('display_math', 'ejsapp'));
        $mform->disabledIf('display_math', 'use_blockly', 'eq', 0);

        $mform->addElement('selectyesno', 'display_text', get_string('display_text', 'ejsapp'));
        $mform->disabledIf('display_text', 'use_blockly', 'eq', 0);

        $mform->addElement('selectyesno', 'display_lists', get_string('display_lists', 'ejsapp'));
        $mform->disabledIf('display_lists', 'use_blockly', 'eq', 0);

        $mform->addElement('selectyesno', 'display_variables', get_string('display_variables', 'ejsapp'));
        $mform->disabledIf('display_variables', 'use_blockly', 'eq', 0);

        $mform->addElement('selectyesno', 'display_functions', get_string('display_functions', 'ejsapp'));
        $mform->disabledIf('display_functions', 'use_blockly', 'eq', 0);

        $mform->addElement('selectyesno', 'display_lab', get_string('display_lab', 'ejsapp'));
        $mform->addHelpButton('display_lab', 'display_lab', 'ejsapp');
        $mform->disabledIf('display_lab', 'use_blockly', 'eq', 0);

        $mform->addElement('selectyesno', 'display_lab_variables', get_string('display_lab_variables', 'ejsapp'));
        $mform->disabledIf('display_lab_variables', 'use_blockly', 'eq', 0);
        $mform->disabledIf('display_lab_variables', 'display_lab', 'eq', 0);

        $mform->addElement('selectyesno', 'display_lab_functions', get_string('display_lab_functions', 'ejsapp'));
        $mform->disabledIf('display_lab_functions', 'use_blockly', 'eq', 0);
        $mform->disabledIf('display_lab_functions', 'display_lab', 'eq', 0);

        $mform->addElement('selectyesno', 'display_lab_control', get_string('display_lab_control', 'ejsapp'));
        $mform->disabledIf('display_lab_control', 'use_blockly', 'eq', 0);
        $mform->disabledIf('display_lab_control', 'display_lab', 'eq', 0);

        // Adding an optional text file with a recording to automatically run it when the lab loads
        $mform->addElement('filemanager', 'blocklyfile', get_string('blocklyfile', 'ejsapp'), null, array('subdirs' => 0, 'maxbytes' => $maxbytes, 'maxfiles' => 1, 'accepted_types' => '.blk'));
        $mform->addHelpButton('blocklyfile', 'blocklyfile', 'ejsapp');
        $mform->disabledIf('blocklyfile', 'use_blockly', 'eq', 0);
        // -------------------------------------------------------------------------------
        // Adding elements to configure the remote lab, if that's the case
        $mform->addElement('header', 'rem_lab', get_string('rem_lab_conf', 'ejsapp'));

        $mform->addElement('selectyesno', 'is_rem_lab', get_string('is_rem_lab', 'ejsapp'));
        $mform->addHelpButton('is_rem_lab', 'is_rem_lab', 'ejsapp');
        $is_remlab_manager_installed = $DB->get_records('block', array('name'=>'remlab_manager'));
        $is_remlab_manager_installed = !empty($is_remlab_manager_installed);
        $mform->setDefault('remlab_manager', $is_remlab_manager_installed ? 1 : 0);
        $mform->setDefault('is_rem_lab', 0);
        $mform->disabledIf('is_rem_lab', 'remlab_manager', 'eq', 0);

        if ($is_remlab_manager_installed) $list_showable_experiences = get_showable_experiences();
        else $list_showable_experiences = array();
        $mform->addElement('select', 'practiceintro', get_string('practiceintro', 'ejsapp'), $list_showable_experiences);
        $mform->addHelpButton('practiceintro', 'practiceintro', 'ejsapp');
        $mform->disabledIf('practiceintro', 'is_rem_lab', 'eq', 0);
        if ($this->current->instance && $is_remlab_manager_installed) {
            $practiceintro = $DB->get_field('block_remlab_manager_exp2prc', 'practiceintro', array('ejsappid' => $this->current->instance));
            if ($practiceintro) {
                $i = 0;
                $selected_practice_index = $i;
                foreach ($list_showable_experiences as $sarlab_experience) {
                    if ($practiceintro == $sarlab_experience) {
                        $selected_practice_index = $i;
                        break;
                    }
                    $i++;
                }
                $mform->setDefault('practiceintro', $selected_practice_index);
            } else {
                $mform->setDefault('practiceintro', '');
            }
        }
        $mform->addElement('hidden', 'list_practices', null);
        $mform->setType('list_practices', PARAM_TEXT);
        $string_showable_experiences = '';
        foreach ($list_showable_experiences as $experience) {
            $string_showable_experiences .= $experience . ';';
        }
        $mform->setDefault('list_practices', $string_showable_experiences);
        // -------------------------------------------------------------------------------
        // Add standard elements, common to all modules
        $this->standard_coursemodule_elements();
        // -------------------------------------------------------------------------------
        // Add standard buttons, common to all modules
        $this->add_action_buttons();
    } // definition


    /**
     * Any data processing needed before the form is displayed
     * (needed to set up draft areas for editor and filemanager elements)
     * @param array &$default_values
     */
    function data_preprocessing(&$default_values)
    {
        global $CFG, $DB;

        $maxbytes = get_max_upload_file_size($CFG->maxbytes);

        // Fill the form elements with previous submitted files/data
        if ($this->current->instance) {
            $draftitemid = file_get_submitted_draft_itemid('appletfile');
            file_prepare_draft_area($draftitemid, $this->context->id, 'mod_ejsapp', 'jarfiles', $this->current->instance, array('subdirs' => 0, 'maxbytes' => $maxbytes, 'maxfiles' => 1, 'accepted_types' => array('application/java-archive', 'application/zip')));
            $default_values['appletfile'] = $draftitemid;

            $draftitemid_wording = file_get_submitted_draft_itemid('appwording');
            $default_values['ejsappwording']['format'] = $default_values['appwordingformat'];
            $default_values['ejsappwording']['text'] = file_prepare_draft_area($draftitemid_wording, $this->context->id, 'mod_ejsapp', 'appwording', 0, array('subdirs' => 1, 'maxbytes' => $CFG->maxbytes, 'changeformat' => 1, 'context' => $this->context, 'noclean' => 1, 'trusttext' => 0), $default_values['appwording']);
            $default_values['ejsappwording']['itemid'] = $draftitemid_wording;
            
            $draftitemid_state = file_get_submitted_draft_itemid('statefile');
            file_prepare_draft_area($draftitemid_state, $this->context->id, 'mod_ejsapp', 'xmlfiles', $this->current->instance, array('subdirs' => 0, 'maxbytes' => $maxbytes, 'maxfiles' => 1, 'accepted_types' => 'application/xml'));
            $default_values['statefile'] = $draftitemid_state;

            $draftitemid_controller = file_get_submitted_draft_itemid('controllerfile');
            file_prepare_draft_area($draftitemid_controller, $this->context->id, 'mod_ejsapp', 'cntfiles', $this->current->instance, array('subdirs' => 0, 'maxbytes' => $maxbytes, 'maxfiles' => 1));
            $default_values['controllerfile'] = $draftitemid_controller;

            $draftitemid_recording = file_get_submitted_draft_itemid('recordingfile');
            file_prepare_draft_area($draftitemid_recording, $this->context->id, 'mod_ejsapp', 'recfiles', $this->current->instance, array('subdirs' => 0, 'maxbytes' => $maxbytes, 'maxfiles' => 1));
            $default_values['recordingfile'] = $draftitemid_recording;

            $draftitemid_blockly = file_get_submitted_draft_itemid('blocklyfile');
            file_prepare_draft_area($draftitemid_blockly, $this->context->id, 'mod_ejsapp', 'blkfiles', $this->current->instance, array('subdirs' => 0, 'maxbytes' => $maxbytes, 'maxfiles' => 1));
            $default_values['blocklyfile'] = $draftitemid_blockly;

            $personal_vars = $DB->get_records('ejsapp_personal_vars', array('ejsappid' => $this->current->instance));
            $key = 0;
            foreach ($personal_vars as $personal_var) {
                $default_values['var_name['.$key.']'] = $personal_var->name;
                $vartype = '0';
                if ($personal_var->type == 'Integer') $vartype = '1';
                elseif ($personal_var->type == 'Double') $vartype = '2';
                $default_values['var_type['.$key.']'] = $vartype;
                if ($vartype != 0) {
                    $default_values['min_value['.$key.']'] = $personal_var->minval;
                    $default_values['max_value['.$key.']'] = $personal_var->maxval;
                }
                $key ++;
            }

            $json_blockly_configuration = $DB->get_field('ejsapp', 'blockly_conf', array('id' => $this->current->instance));
            $blockly_configuration =json_decode($json_blockly_configuration);
            $default_values['use_blockly'] = $blockly_configuration[0];
            $default_values['display_logic'] = $blockly_configuration[1];
            $default_values['display_loops'] = $blockly_configuration[2];
            $default_values['display_math'] = $blockly_configuration[3];
            $default_values['display_text'] = $blockly_configuration[4];
            $default_values['display_lists'] = $blockly_configuration[5];
            $default_values['display_variables'] = $blockly_configuration[6];
            $default_values['display_functions'] = $blockly_configuration[7];
            $default_values['display_lab'] = $blockly_configuration[8];
            $default_values['display_lab_variables'] = $blockly_configuration[9];
            $default_values['display_lab_functions'] = $blockly_configuration[10];
            $default_values['display_lab_control'] = $blockly_configuration[11];
        }

        // Element listing EJS public variables
        // $PAGE->requires->js_init_call;
        // TODO: Get list of public variables: their names, values and types
        // </Set the mod_form elements>
    } // data_preprocessing


    /**
     * Performs minimal validation on the settings form
     * @param array $data
     * @param array $files
     * @return array $errors
     */
    function validation($data, $files)
    {
        $errors = parent::validation($data, $files);

        if ($data['applet_size_conf'] == 2) {
            if (empty($data['custom_width'])) {
                $errors['custom_width'] = get_string('custom_width_required', 'ejsapp');
            }
            if ($data['preserve_aspect_ratio'] == 0) {
                if (empty($data['custom_height'])) {
                    $errors['custom_height'] = get_string('custom_height_required', 'ejsapp');
                }
            }
        }

        if ($data['personalvars'] == 1) {
            if (empty($data['var_name'])) {
                $errors['var_name[0]'] = get_string('vars_required', 'ejsapp');
            }
            $i = 0;
            foreach ($data['var_type'] as $this_var_type) {
                $min_values = $data['min_value'];
                $max_values = $data['max_value'];
                if ($this_var_type == 1 && (!(floor($min_values[$i]) == $min_values[$i]) || !(floor($max_values[$i]) == $max_values[$i]))) {
                    $errors['var_type['.$i.']'] = get_string('vars_incorrect_type', 'ejsapp');
                } elseif ($this_var_type == 2 && (!is_float($min_values[$i]) || !is_float($max_values[$i]))) {
                    $errors['var_type['.$i.']'] = get_string('vars_incorrect_type', 'ejsapp');
                }
                $i++;
            }
        }

        if ($data['is_rem_lab'] == 1) {
            if ($data['practiceintro'] == '') {
                $errors['practiceintro'] = get_string('practiceintro_required', 'ejsapp');
            }
        }

        return $errors;
    } // validation


} // class mod_ejsapp_mod_form