<?php if (!defined('BASEPATH')) exit('Direct access not allowed!');

class About_us_model extends MY_Model
{

    public function __construct()
    {

        parent::__construct();
        $this->table = "about_us";
        $this->pk = "about_us_page_id";
        $this->status = "status";
        $this->order = "order";
    }

    public function validate_form_data()
    {
        $validation_config = array(

            array(
                "field"  =>  "about_us_page_id",
                "label"  =>  "About Us Page Id",
                "rules"  =>  "required"
            ),

            array(
                "field"  =>  "about_us_page_title",
                "label"  =>  "About Us Page Title",
                "rules"  =>  "required"
            ),

            array(
                "field"  =>  "about_us_page_description",
                "label"  =>  "About Us Page Description",
                "rules"  =>  "required"
            ),

            array(
                "field"  =>  "about_us_page_keyword",
                "label"  =>  "About Us Page Keyword",
                "rules"  =>  "required"
            ),

            array(
                "field"  =>  "about_us_page_content",
                "label"  =>  "About Us Page Content",
                "rules"  =>  "required"
            ),

            // array(
            //     "field"  =>  "image",
            //     "label"  =>  "Image",
            //     "rules"  =>  "required"
            // ),

        );
        //set and run the validation
        $this->form_validation->set_rules($validation_config);
        return $this->form_validation->run();
    }

    public function save_data($image_field = NULL)
    {
        $inputs = array();

        $inputs["about_us_page_id"]  =  $this->input->post("about_us_page_id");

        $inputs["about_us_page_title"]  =  $this->input->post("about_us_page_title");

        $inputs["about_us_page_description"]  =  $this->input->post("about_us_page_description");

        $inputs["about_us_page_keyword"]  =  $this->input->post("about_us_page_keyword");

        $inputs["about_us_page_content"]  =  $this->input->post("about_us_page_content");

        if ($_FILES["image"]["size"] > 0) {
            $inputs["image"]  =  $this->router->fetch_class() . "/" . $this->input->post("image");
        }

        return $this->about_us_model->save($inputs);
    }

    public function update_data($about_us_page_id, $image_field = NULL)
    {
        $inputs = array();

        $inputs["about_us_page_id"]  =  $this->input->post("about_us_page_id");

        $inputs["about_us_page_title"]  =  $this->input->post("about_us_page_title");

        $inputs["about_us_page_description"]  =  $this->input->post("about_us_page_description");

        $inputs["about_us_page_keyword"]  =  $this->input->post("about_us_page_keyword");

        $inputs["about_us_page_content"]  =  $this->input->post("about_us_page_content");

        if ($_FILES["image"]["size"] > 0) {
            //remove previous file....
            $about_us = $this->get_about_us($about_us_page_id);
            $file_path = $about_us[0]->image;
            $this->delete_file($file_path);
            $inputs["image"]  =  $this->router->fetch_class() . "/" . $this->input->post("image");
        }

        return $this->about_us_model->save($inputs, $about_us_page_id);
    }

    //----------------------------------------------------------------
    public function get_about_us_list($where_condition = NULL, $pagination = TRUE, $public = FALSE)
    {
        $data = (object) array();
        $fields = array("about_us.*");
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
                $this->about_us_model->uri_segment = $this->uri->segment(3);
                $config["base_url"]  = base_url($this->uri->segment(1) . "/" . $this->uri->segment(2));
            } else {
                $this->about_us_model->uri_segment = $this->uri->segment(4);
                $config["base_url"]  = base_url(ADMIN_DIR . $this->uri->segment(2) . "/" . $this->uri->segment(3));
            }
            $config["total_rows"] = $this->about_us_model->joinGet($fields, "about_us", $join_table, $where, true);
            $this->pagination->initialize($config);
            $data->pagination = $this->pagination->create_links();
            $data->about_us = $this->about_us_model->joinGet($fields, "about_us", $join_table, $where);
            return $data;
        } else {
            return $this->about_us_model->joinGet($fields, "about_us", $join_table, $where, FALSE, TRUE);
        }
    }

    public function get_about_us($about_us_page_id)
    {

        $fields = array("about_us.*");
        $join_table = array();
        $where = "about_us.about_us_page_id = $about_us_page_id";

        return $this->about_us_model->joinGet($fields, "about_us", $join_table, $where, FALSE, TRUE);
    }
}
