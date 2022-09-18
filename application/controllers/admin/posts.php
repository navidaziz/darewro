<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Posts extends Admin_Controller
{

    /**
     * constructor method
     */
    public function __construct()
    {

        parent::__construct();
        $this->load->model("admin/post_model");
        $this->lang->load("posts", 'english');
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

        $where = "`posts`.`status` IN (0, 1) ";
        $data = $this->post_model->get_post_list($where);
        $this->data["posts"] = $data->posts;
        $this->data["pagination"] = $data->pagination;
        $this->data["title"] = $this->lang->line('Posts');
        $this->data["view"] = ADMIN_DIR . "posts/posts";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * get single record by id
     */
    public function view_post($post_id)
    {

        $post_id = (int) $post_id;

        $this->data["posts"] = $this->post_model->get_post($post_id);
        $this->data["title"] = $this->lang->line('Post Details');
        $this->data["view"] = ADMIN_DIR . "posts/view_post";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * get a list of all trashed items
     */
    public function trashed()
    {

        $where = "`posts`.`status` IN (2) ";
        $data = $this->post_model->get_post_list($where);
        $this->data["posts"] = $data->posts;
        $this->data["pagination"] = $data->pagination;
        $this->data["title"] = $this->lang->line('Trashed Posts');
        $this->data["view"] = ADMIN_DIR . "posts/trashed_posts";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * function to send a user to trash
     */
    public function trash($post_id, $page_id = NULL)
    {

        $post_id = (int) $post_id;


        $this->post_model->changeStatus($post_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR . "posts/view/" . $page_id);
    }

    /**
     * function to restor post from trash
     * @param $post_id integer
     */
    public function restore($post_id, $page_id = NULL)
    {

        $post_id = (int) $post_id;


        $this->post_model->changeStatus($post_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR . "posts/trashed/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to draft post from trash
     * @param $post_id integer
     */
    public function draft($post_id, $page_id = NULL)
    {

        $post_id = (int) $post_id;


        $this->post_model->changeStatus($post_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR . "posts/view/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to publish post from trash
     * @param $post_id integer
     */
    public function publish($post_id, $page_id = NULL)
    {

        $post_id = (int) $post_id;


        $this->post_model->changeStatus($post_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR . "posts/view/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to permanently delete a Post
     * @param $post_id integer
     */
    public function delete($post_id, $page_id = NULL)
    {

        $post_id = (int) $post_id;
        //$this->post_model->changeStatus($post_id, "3");
        //Remove file....
        $posts = $this->post_model->get_post($post_id);
        $file_path = $posts[0]->image;
        $this->post_model->delete_file($file_path);
        $this->post_model->delete(array('post_id' => $post_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR . "posts/trashed/" . $page_id);
    }
    //----------------------------------------------------



    /**
     * function to add new Post
     */
    public function add()
    {

        $this->data["title"] = $this->lang->line('Add New Post');
        $this->data["view"] = ADMIN_DIR . "posts/add_post";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //--------------------------------------------------------------------
    public function save_data()
    {
        if ($this->post_model->validate_form_data() === TRUE) {
            $post_type = $this->input->post('post_type');
            if ($post_type == 'Image') {
                if ($this->upload_file("image")) {
                    $_POST['image'] = $this->data["upload_data"]["file_name"];
                }
            }

            $post_id = $this->post_model->save_data();
            if ($post_id) {
                $this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR . "posts/edit/$post_id");
            } else {

                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR . "posts/add");
            }
        } else {
            $this->add();
        }
    }


    /**
     * function to edit a Post
     */
    public function edit($post_id)
    {
        $post_id = (int) $post_id;
        $this->data["post"] = $this->post_model->get($post_id);

        $this->data["title"] = $this->lang->line('Edit Post');
        $this->data["view"] = ADMIN_DIR . "posts/edit_post";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //--------------------------------------------------------------------

    public function update_data($post_id)
    {

        $post_id = (int) $post_id;

        if ($this->post_model->validate_form_data() === TRUE) {
            $post_type = $this->input->post('post_type');
            if ($post_type == 'Image') {
                if ($this->upload_file("image")) {
                    $_POST["image"] = $this->data["upload_data"]["file_name"];
                }
            }

            $post_id = $this->post_model->update_data($post_id);
            if ($post_id) {





                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR . "posts/edit/$post_id");
            } else {

                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR . "posts/edit/$post_id");
            }
        } else {
            $this->edit($post_id);
        }
    }


    /**
     * get data as a json array 
     */
    public function get_json()
    {
        $where = array("status" => 1);
        $where[$this->uri->segment(3)] = $this->uri->segment(4);
        $data["posts"] = $this->post_model->getBy($where, false, "post_id");
        $j_array[] = array("id" => "", "value" => "post");
        foreach ($data["posts"] as $post) {
            $j_array[] = array("id" => $post->post_id, "value" => "");
        }
        echo json_encode($j_array);
    }
    //-----------------------------------------------------

}
