<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class About_us extends Admin_Controller
{

    /**
     * constructor method
     */
    public function __construct()
    {

        parent::__construct();
        $this->load->model("admin/about_us_model");
        $this->lang->load("about_us", 'english');
        $this->lang->load("system", 'english');
        //$this->output->enable_profiler(TRUE);
    }
    //---------------------------------------------------------------


    /**
     * Default action to be called
     */
    public function index()
    {
        $main_page = base_url() . ADMIN_DIR . $this->router->fetch_class() . "/view";
        redirect($main_page);
    }
    //---------------------------------------------------------------



    /**
     * get a list of all items that are not trashed
     */
    public function view()
    {

        $about_us_page_id = 1;

        $this->data["about_us"] = $this->about_us_model->get_about_us($about_us_page_id);
        $this->data["title"] = $this->lang->line('About Us Details');
        $this->data["view"] = ADMIN_DIR . "about_us/view_about_us";
        $this->load->view(ADMIN_DIR . "layout", $this->data);

        // $where = "`about_us`.`status` IN (0, 1) ";
        // $data = $this->about_us_model->get_about_us_list($where);
        //  $this->data["about_us"] = $data->about_us;
        //  $this->data["pagination"] = $data->pagination;
        //  $this->data["title"] = $this->lang->line('About Us');
        // $this->data["view"] = ADMIN_DIR."about_us/about_us";
        // $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * get single record by id
     */
    public function view_about_us($about_us_page_id)
    {

        $about_us_page_id = (int) $about_us_page_id;

        $this->data["about_us"] = $this->about_us_model->get_about_us($about_us_page_id);
        $this->data["title"] = $this->lang->line('About Us Details');
        $this->data["view"] = ADMIN_DIR . "about_us/view_about_us";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * get a list of all trashed items
     */
    public function trashed()
    {

        $where = "`about_us`.`status` IN (2) ";
        $data = $this->about_us_model->get_about_us_list($where);
        $this->data["about_us"] = $data->about_us;
        $this->data["pagination"] = $data->pagination;
        $this->data["title"] = $this->lang->line('Trashed About Us');
        $this->data["view"] = ADMIN_DIR . "about_us/trashed_about_us";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * function to send a user to trash
     */
    public function trash($about_us_page_id, $page_id = NULL)
    {

        $about_us_page_id = (int) $about_us_page_id;


        $this->about_us_model->changeStatus($about_us_page_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR . "about_us/view/" . $page_id);
    }

    /**
     * function to restor about_us from trash
     * @param $about_us_page_id integer
     */
    public function restore($about_us_page_id, $page_id = NULL)
    {

        $about_us_page_id = (int) $about_us_page_id;


        $this->about_us_model->changeStatus($about_us_page_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR . "about_us/trashed/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to draft about_us from trash
     * @param $about_us_page_id integer
     */
    public function draft($about_us_page_id, $page_id = NULL)
    {

        $about_us_page_id = (int) $about_us_page_id;


        $this->about_us_model->changeStatus($about_us_page_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR . "about_us/view/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to publish about_us from trash
     * @param $about_us_page_id integer
     */
    public function publish($about_us_page_id, $page_id = NULL)
    {

        $about_us_page_id = (int) $about_us_page_id;


        $this->about_us_model->changeStatus($about_us_page_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR . "about_us/view/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to permanently delete a About_us
     * @param $about_us_page_id integer
     */
    public function delete($about_us_page_id, $page_id = NULL)
    {

        $about_us_page_id = (int) $about_us_page_id;
        //$this->about_us_model->changeStatus($about_us_page_id, "3");
        //Remove file....
        $about_us = $this->about_us_model->get_about_us($about_us_page_id);
        $file_path = $about_us[0]->image;
        $this->about_us_model->delete_file($file_path);
        $this->about_us_model->delete(array('about_us_page_id' => $about_us_page_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR . "about_us/trashed/" . $page_id);
    }
    //----------------------------------------------------



    /**
     * function to add new About_us
     */
    public function add()
    {

        $this->data["title"] = $this->lang->line('Add New About Us');
        $this->data["view"] = ADMIN_DIR . "about_us/add_about_us";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //--------------------------------------------------------------------
    public function save_data()
    {
        if ($this->about_us_model->validate_form_data() === TRUE) {

            if ($this->upload_file("image")) {
                $_POST['image'] = $this->data["upload_data"]["file_name"];
            }

            $about_us_page_id = $this->about_us_model->save_data();
            if ($about_us_page_id) {
                $this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR . "about_us/edit/$about_us_page_id");
            } else {

                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR . "about_us/add");
            }
        } else {
            $this->add();
        }
    }


    /**
     * function to edit a About_us
     */
    public function edit()
    {
        $about_us_page_id = 1;
        $this->data["about_us"] = $this->about_us_model->get($about_us_page_id);

        $this->data["title"] = $this->lang->line('Edit About Us');
        $this->data["view"] = ADMIN_DIR . "about_us/edit_about_us";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //--------------------------------------------------------------------

    public function update_data($about_us_page_id)
    {

        $about_us_page_id = (int) $about_us_page_id;

        if ($this->about_us_model->validate_form_data() === TRUE) {

            if ($this->upload_file("image")) {
                $_POST["image"] = $this->data["upload_data"]["file_name"];
            }

            $about_us_page_id = $this->about_us_model->update_data($about_us_page_id);
            if ($about_us_page_id) {

                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR . "about_us/edit/$about_us_page_id");
            } else {

                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR . "about_us/edit/$about_us_page_id");
            }
        } else {
            $this->edit($about_us_page_id);
        }
    }


    /**
     * get data as a json array 
     */
    public function get_json()
    {
        $where = array("status" => 1);
        $where[$this->uri->segment(3)] = $this->uri->segment(4);
        $data["about_us"] = $this->about_us_model->getBy($where, false, "about_us_page_id");
        $j_array[] = array("id" => "", "value" => "about_us");
        foreach ($data["about_us"] as $about_us) {
            $j_array[] = array("id" => $about_us->about_us_page_id, "value" => "");
        }
        echo json_encode($j_array);
    }
    //-----------------------------------------------------

}
