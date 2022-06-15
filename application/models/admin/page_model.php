<?php if (!defined('BASEPATH')) exit('Direct access not allowed!');

class Page_model extends MY_Model
{

    public function __construct()
    {

        parent::__construct();
        $this->table = "pages";
        $this->pk = "page_id";
        $this->status = "status";
        $this->order = "order";
    }

    public function validate_form_data()
    {
        $validation_config = array(

            array(
                "field"  =>  "page_name",
                "label"  =>  "Page Name",
                "rules"  =>  "required"
            ),

            array(
                "field"  =>  "page_content",
                "label"  =>  "Page Content",
                "rules"  =>  "required"
            ),

            array(
                "field"  =>  "page_title",
                "label"  =>  "Page Title",
                "rules"  =>  "required"
            ),

            array(
                "field"  =>  "page_description",
                "label"  =>  "Page Description",
                "rules"  =>  "required"
            ),

            array(
                "field"  =>  "page_keywords",
                "label"  =>  "Page Keywords",
                "rules"  =>  "required"
            ),
            array(
                "field"  =>  "icon",
                "label"  =>  "Icon required",
                "rules"  =>  "required"
            ),

        );
        //set and run the validation
        $this->form_validation->set_rules($validation_config);
        return $this->form_validation->run();
    }

    public function save_data($image_field = NULL)
    {
        $inputs = array();

        $inputs["page_name"]  =  $this->input->post("page_name");

        $inputs["page_content"]  =  $this->input->post("page_content");

        $inputs["page_title"]  =  $this->input->post("page_title");

        $inputs["page_description"]  =  $this->input->post("page_description");

        $inputs["page_keywords"]  =  $this->input->post("page_keywords");

        $inputs["icon"]  =  $this->input->post("icon");

        return $this->page_model->save($inputs);
    }

    public function update_data($page_id, $image_field = NULL)
    {
        $inputs = array();

        $inputs["page_name"]  =  $this->input->post("page_name");

        $inputs["page_content"]  =  $this->input->post("page_content");

        $inputs["page_title"]  =  $this->input->post("page_title");

        $inputs["page_description"]  =  $this->input->post("page_description");

        $inputs["page_keywords"]  =  $this->input->post("page_keywords");
        $inputs["icon"]  =  $this->input->post("icon");

        return $this->page_model->save($inputs, $page_id);
    }

    //----------------------------------------------------------------
    public function get_page_list($where_condition = NULL, $pagination = TRUE, $public = FALSE)
    {
        $data = (object) array();
        $fields = array("pages.*");
        $join_table = array();
        if (!is_null($where_condition)) {
            $where = $where_condition;
        } else {
            $where = "";
        }

        if ($pagination) {
            //configure the pagination
            $this->load->library("pagination");

            if ($public) {
                $config['per_page'] = 10;
                $config['uri_segment'] = 3;
                $this->page_model->uri_segment = $this->uri->segment(3);
                $config["base_url"]  = base_url($this->uri->segment(1) . "/" . $this->uri->segment(2));
            } else {
                $this->page_model->uri_segment = $this->uri->segment(4);
                $config["base_url"]  = base_url(ADMIN_DIR . $this->uri->segment(2) . "/" . $this->uri->segment(3));
            }
            $config["total_rows"] = $this->page_model->joinGet($fields, "pages", $join_table, $where, true);
            $this->pagination->initialize($config);
            $data->pagination = $this->pagination->create_links();
            $data->pages = $this->page_model->joinGet($fields, "pages", $join_table, $where);
            return $data;
        } else {
            return $this->page_model->joinGet($fields, "pages", $join_table, $where, FALSE, TRUE);
        }
    }

    public function get_page($page_id)
    {

        $fields = array("pages.*");
        $join_table = array();
        $where = "pages.page_id = $page_id";

        return $this->page_model->joinGet($fields, "pages", $join_table, $where, FALSE, TRUE);
    }
}
