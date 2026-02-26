<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'controllers/Pattern_Controller.php';

/**
 * Handles all project membership actions: adding, removing, and changing
 * permission levels for project members.
 *
 * All endpoints expect POST data and are called via AJAX.
 *
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property CI_Session $session
 * @property Project_Model $Project_Model
 */
class Project_Member_Controller extends Pattern_Controller
{
    /**
     * Add a member to a project
     * URL: /project_member/add_member
     * POST: email, id_project, level
     */
    public function add_member()
    {
        try {
            $email      = $this->input->post('email');
            $id_project = $this->input->post('id_project');
            $level      = $this->input->post('level');

            $this->validate_level($id_project, [1]);
            $this->load->model('Project_Model');

            $name = $this->Project_Model->add_member($email, $level, $id_project);

            $this->insert_log('Added member ' . $email, 1, $id_project);

            echo $name;
        } catch (Exception $e) {
            $this->session->set_flashdata('error', $e->getMessage());
            redirect(base_url());
        }
    }

    /**
     * Remove a member from a project
     * URL: /project_member/delete_member
     * POST: email, id_project
     */
    public function delete_member()
    {
        try {
            $id_project = $this->input->post('id_project');
            $email      = $this->input->post('email');

            $this->validate_level($id_project, [1]);
            $this->load->model('Project_Model');

            $this->Project_Model->delete_member($email, $id_project);

            $this->insert_log('Deleted member ' . $email, 1, null);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Change a member's permission level
     * URL: /project_member/edit_level
     * POST: email, id_project, level
     */
    public function edit_level()
    {
        try {
            $id_project = $this->input->post('id_project');
            $email      = $this->input->post('email');
            $level      = $this->input->post('level');

            $this->validate_level($id_project, [1]);
            $this->load->model('Project_Model');

            $this->Project_Model->edit_level($email, $level, $id_project);

            $this->insert_log('Edit level ' . $level . ' member ' . $email, 1, null);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
