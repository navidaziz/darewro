<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Why_choose_us extends Admin_Controller
{

    /**
     * constructor method
     */
    public function __construct()
    {

        parent::__construct();
        $this->load->model("admin/why_choose_us_model");
        $this->lang->load("why_choose_us", 'english');
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

        $where = "`why_choose_us`.`status` IN (0, 1) ORDER BY `why_choose_us`.`order`";
        $data = $this->why_choose_us_model->get_why_choose_us_list($where);
        $this->data["why_choose_us"] = $data->why_choose_us;
        $this->data["pagination"] = $data->pagination;
        $this->data["title"] = $this->lang->line('Why Choose Us');
        $this->data["view"] = ADMIN_DIR . "why_choose_us/why_choose_us";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * get single record by id
     */
    public function view_why_choose_us($why_choose_us_id)
    {

        $why_choose_us_id = (int) $why_choose_us_id;

        $this->data["why_choose_us"] = $this->why_choose_us_model->get_why_choose_us($why_choose_us_id);
        $this->data["title"] = $this->lang->line('Why Choose Us Details');
        $this->data["view"] = ADMIN_DIR . "why_choose_us/view_why_choose_us";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * get a list of all trashed items
     */
    public function trashed()
    {

        $where = "`why_choose_us`.`status` IN (2) ORDER BY `why_choose_us`.`order`";
        $data = $this->why_choose_us_model->get_why_choose_us_list($where);
        $this->data["why_choose_us"] = $data->why_choose_us;
        $this->data["pagination"] = $data->pagination;
        $this->data["title"] = $this->lang->line('Trashed Why Choose Us');
        $this->data["view"] = ADMIN_DIR . "why_choose_us/trashed_why_choose_us";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * function to send a user to trash
     */
    public function trash($why_choose_us_id, $page_id = NULL)
    {

        $why_choose_us_id = (int) $why_choose_us_id;


        $this->why_choose_us_model->changeStatus($why_choose_us_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR . "why_choose_us/view/" . $page_id);
    }

    /**
     * function to restor why_choose_us from trash
     * @param $why_choose_us_id integer
     */
    public function restore($why_choose_us_id, $page_id = NULL)
    {

        $why_choose_us_id = (int) $why_choose_us_id;


        $this->why_choose_us_model->changeStatus($why_choose_us_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR . "why_choose_us/trashed/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to draft why_choose_us from trash
     * @param $why_choose_us_id integer
     */
    public function draft($why_choose_us_id, $page_id = NULL)
    {

        $why_choose_us_id = (int) $why_choose_us_id;


        $this->why_choose_us_model->changeStatus($why_choose_us_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR . "why_choose_us/view/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to publish why_choose_us from trash
     * @param $why_choose_us_id integer
     */
    public function publish($why_choose_us_id, $page_id = NULL)
    {

        $why_choose_us_id = (int) $why_choose_us_id;


        $this->why_choose_us_model->changeStatus($why_choose_us_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR . "why_choose_us/view/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to permanently delete a Why_choose_us
     * @param $why_choose_us_id integer
     */
    public function delete($why_choose_us_id, $page_id = NULL)
    {

        $why_choose_us_id = (int) $why_choose_us_id;
        //$this->why_choose_us_model->changeStatus($why_choose_us_id, "3");

        $this->why_choose_us_model->delete(array('why_choose_us_id' => $why_choose_us_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR . "why_choose_us/trashed/" . $page_id);
    }
    //----------------------------------------------------



    /**
     * function to add new Why_choose_us
     */
    public function add()
    {

        $this->data["title"] = $this->lang->line('Add New Why Choose Us');
        $this->data["view"] = ADMIN_DIR . "why_choose_us/add_why_choose_us";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //--------------------------------------------------------------------
    public function save_data()
    {
        if ($this->why_choose_us_model->validate_form_data() === TRUE) {
            if ($this->upload_file("attachment")) {
                $_POST['attachment'] = $this->data["upload_data"]["file_name"];
            }
            $why_choose_us_id = $this->why_choose_us_model->save_data();
            if ($why_choose_us_id) {
                $this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR . "why_choose_us/edit/$why_choose_us_id");
            } else {

                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR . "why_choose_us/add");
            }
        } else {
            $this->add();
        }
    }


    /**
     * function to edit a Why_choose_us
     */
    public function edit($why_choose_us_id)
    {
        $why_choose_us_id = (int) $why_choose_us_id;




        $this->data["why_choose_us"] = $this->why_choose_us_model->get($why_choose_us_id);



        $this->data["title"] = $this->lang->line('Edit Why Choose Us');
        $this->data["view"] = ADMIN_DIR . "why_choose_us/edit_why_choose_us";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //--------------------------------------------------------------------

    public function update_data($why_choose_us_id)
    {

        $why_choose_us_id = (int) $why_choose_us_id;

        if ($this->why_choose_us_model->validate_form_data() === TRUE) {

            if ($this->upload_file("attachment")) {
                $_POST["attachment"] = $this->data["upload_data"]["file_name"];
            }

            $why_choose_us_id = $this->why_choose_us_model->update_data($why_choose_us_id);
            if ($why_choose_us_id) {

                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR . "why_choose_us/edit/$why_choose_us_id");
            } else {

                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR . "why_choose_us/edit/$why_choose_us_id");
            }
        } else {
            $this->edit($why_choose_us_id);
        }
    }


    /**
     * function to move a record up in list
     * @param $why_choose_us_id id of the record
     * @param $page_id id of the page to be redirected to
     */
    public function up($why_choose_us_id, $page_id = NULL)
    {

        $why_choose_us_id = (int) $why_choose_us_id;

        //get order number of this record
        $this_why_choose_us_where = "why_choose_us_id = $why_choose_us_id";
        $this_why_choose_us = $this->why_choose_us_model->getBy($this_why_choose_us_where, true);
        $this_why_choose_us_id = $why_choose_us_id;
        $this_why_choose_us_order = $this_why_choose_us->order;


        //get order number of previous record
        $previous_why_choose_us_where = "order <= $this_why_choose_us_order AND why_choose_us_id != $why_choose_us_id ORDER BY `order` DESC";
        $previous_why_choose_us = $this->why_choose_us_model->getBy($previous_why_choose_us_where, true);
        $previous_why_choose_us_id = $previous_why_choose_us->why_choose_us_id;
        $previous_why_choose_us_order = $previous_why_choose_us->order;

        //if this is the first element
        if (!$previous_why_choose_us_id) {
            redirect(ADMIN_DIR . "why_choose_us/view/" . $page_id);
            exit;
        }


        //now swap the order
        $this_why_choose_us_inputs = array(
            "order" => $previous_why_choose_us_order
        );
        $this->why_choose_us_model->save($this_why_choose_us_inputs, $this_why_choose_us_id);

        $previous_why_choose_us_inputs = array(
            "order" => $this_why_choose_us_order
        );
        $this->why_choose_us_model->save($previous_why_choose_us_inputs, $previous_why_choose_us_id);



        redirect(ADMIN_DIR . "why_choose_us/view/" . $page_id);
    }
    //-------------------------------------------------------------------------------------

    /**
     * function to move a record up in list
     * @param $why_choose_us_id id of the record
     * @param $page_id id of the page to be redirected to
     */
    public function down($why_choose_us_id, $page_id = NULL)
    {

        $why_choose_us_id = (int) $why_choose_us_id;



        //get order number of this record
        $this_why_choose_us_where = "why_choose_us_id = $why_choose_us_id";
        $this_why_choose_us = $this->why_choose_us_model->getBy($this_why_choose_us_where, true);
        $this_why_choose_us_id = $why_choose_us_id;
        $this_why_choose_us_order = $this_why_choose_us->order;


        //get order number of next record

        $next_why_choose_us_where = "order >= $this_why_choose_us_order and why_choose_us_id != $why_choose_us_id ORDER BY `order` ASC";
        $next_why_choose_us = $this->why_choose_us_model->getBy($next_why_choose_us_where, true);
        $next_why_choose_us_id = $next_why_choose_us->why_choose_us_id;
        $next_why_choose_us_order = $next_why_choose_us->order;

        //if this is the first element
        if (!$next_why_choose_us_id) {
            redirect(ADMIN_DIR . "why_choose_us/view/" . $page_id);
            exit;
        }


        //now swap the order
        $this_why_choose_us_inputs = array(
            "order" => $next_why_choose_us_order
        );
        $this->why_choose_us_model->save($this_why_choose_us_inputs, $this_why_choose_us_id);

        $next_why_choose_us_inputs = array(
            "order" => $this_why_choose_us_order
        );
        $this->why_choose_us_model->save($next_why_choose_us_inputs, $next_why_choose_us_id);



        redirect(ADMIN_DIR . "why_choose_us/view/" . $page_id);
    }

    /**
     * get data as a json array 
     */
    public function get_json()
    {
        $where = array("status" => 1);
        $where[$this->uri->segment(3)] = $this->uri->segment(4);
        $data["why_choose_us"] = $this->why_choose_us_model->getBy($where, false, "why_choose_us_id");
        $j_array[] = array("id" => "", "value" => "why_choose_us");
        foreach ($data["why_choose_us"] as $why_choose_us) {
            $j_array[] = array("id" => $why_choose_us->why_choose_us_id, "value" => "");
        }
        echo json_encode($j_array);
    }
    //-----------------------------------------------------

}
