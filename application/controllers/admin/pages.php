<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends Admin_Controller
{

    /**
     * constructor method
     */
    public function __construct()
    {

        parent::__construct();
        $this->load->model("admin/page_model");
        $this->load->model("admin/page_content_model");
        $this->lang->load("page_contents", 'english');
        $this->lang->load("pages", 'english');
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

        $where = "`status` IN (0, 1) ";
        $data = $this->page_model->get_page_list($where);
        $this->data["pages"] = $data->pages;
        $this->data["pagination"] = $data->pagination;
        $this->data["title"] = $this->lang->line('Pages');
        $this->data["view"] = ADMIN_DIR . "pages/pages";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * get single record by id
     */
    public function view_page($pageid)
    {

        $this->data['pageid'] = $pageid = (int) $pageid;

        $this->data["pages"] = $this->page_model->get_page($pageid);
        $where = "`page_contents`.`status` IN (0,1) AND `page_contents`.`page_id` = $pageid  ORDER BY `page_contents`.`order`";
        $this->data["page_contents"] = $this->page_content_model->get_page_content_list($where, FALSE);


        $this->data["title"] = $this->lang->line('Page Details');
        $this->data["view"] = ADMIN_DIR . "pages/view_page";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * get a list of all trashed items
     */
    public function trashed()
    {

        $where = "`status` IN (2) ";
        $data = $this->page_model->get_page_list($where);
        $this->data["pages"] = $data->pages;
        $this->data["pagination"] = $data->pagination;
        $this->data["title"] = $this->lang->line('Trashed Pages');
        $this->data["view"] = ADMIN_DIR . "pages/trashed_pages";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * function to send a user to trash
     */
    public function trash($pageid, $page_id = NULL)
    {

        $pageid = (int) $pageid;


        $this->page_model->changeStatus($pageid, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR . "pages/view/" . $page_id);
    }

    /**
     * function to restor page from trash
     * @param $page_id integer
     */
    public function restore($pageid, $page_id = NULL)
    {

        $pageid = (int) $pageid;


        $this->page_model->changeStatus($pageid, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR . "pages/trashed/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to draft page from trash
     * @param $page_id integer
     */
    public function draft($pageid, $page_id = NULL)
    {

        $pageid = (int) $pageid;


        $this->page_model->changeStatus($pageid, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR . "pages/view/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to publish page from trash
     * @param $page_id integer
     */
    public function publish($pageid, $page_id = NULL)
    {

        $pageid = (int) $pageid;


        $this->page_model->changeStatus($pageid, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR . "pages/view/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to permanently delete a Page
     * @param $page_id integer
     */
    public function delete($pageid, $page_id = NULL)
    {

        $pageid = (int) $pageid;
        //$this->page_model->changeStatus($pageid, "3");

        $this->page_model->delete(array('page_id' => $page_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR . "pages/trashed/" . $page_id);
    }
    //----------------------------------------------------



    /**
     * function to add new Page
     */
    public function add()
    {

        $this->data["title"] = $this->lang->line('Add New Page');
        $this->data["view"] = ADMIN_DIR . "pages/add_page";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //--------------------------------------------------------------------
    public function save_data()
    {
        if ($this->page_model->validate_form_data() === TRUE) {

            $page_id = $this->page_model->save_data();
            if ($page_id) {
                $this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR . "pages/edit/$page_id");
            } else {

                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR . "pages/add");
            }
        } else {
            $this->add();
        }
    }


    /**
     * function to edit a Page
     */
    public function edit($pageid)
    {
        $pageid = (int) $pageid;
        $this->data["page"] = $this->page_model->get($pageid);

        $this->data["title"] = $this->lang->line('Edit Page');
        $this->data["view"] = ADMIN_DIR . "pages/edit_page";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //--------------------------------------------------------------------

    public function update_data($pageid)
    {

        $pageid = (int) $pageid;

        if ($this->page_model->validate_form_data() === TRUE) {

            $page_id = $this->page_model->update_data($pageid);
            if ($page_id) {

                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR . "pages/edit/$page_id");
            } else {

                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR . "pages/edit/$page_id");
            }
        } else {
            $this->edit($pageid);
        }
    }


    public function get_page_content_form($page_id)
    {
        $this->data['page_id'] = (int) $page_id;
        $this->load->view(ADMIN_DIR . "pages/add_page_content", $this->data);
    }

    public function get_page_content_edit_form($page_id)
    {
        $this->data['page_id'] = (int) $page_id;
        $page_content_id = (int) $this->input->post('page_content_id');
        $this->data["page_content"] = $this->page_content_model->get($page_content_id);
        $this->load->view(ADMIN_DIR . "pages/edit_page_content", $this->data);
    }

    /**
     * get data as a json array 
     */
    public function get_json()
    {
        $where = array("status" => 1);
        $where[$this->uri->segment(3)] = $this->uri->segment(4);
        $data["pages"] = $this->page_model->getBy($where, false, "page_id");
        $j_array[] = array("id" => "", "value" => "page");
        foreach ($data["pages"] as $page) {
            $j_array[] = array("id" => $page->page_id, "value" => "");
        }
        echo json_encode($j_array);
    }
    //-----------------------------------------------------

}
