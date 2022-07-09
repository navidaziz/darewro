<?php if (!defined('BASEPATH')) exit('Direct access not allowed!');

class Slider_banner_model extends MY_Model
{

	public function __construct()
	{

		parent::__construct();
		$this->table = "slider_banners";
		$this->pk = "slider_banner_id";
		$this->status = "status";
		$this->order = "order";
	}

	public function validate_form_data()
	{
		return true;
		$validation_config = array(

			// array(
			//     "field"  =>  "slider_banner_title",
			//     "label"  =>  "Slider Banner Title",
			//     "rules"  =>  "required"
			// ),

			// array(
			//     "field"  =>  "slider_banner_sub_title",
			//     "label"  =>  "Slider Banner Sub Title",
			//     "rules"  =>  "required"
			// ),

			// array(
			//     "field"  =>  "slider_banner_detail",
			//     "label"  =>  "Slider Banner Detail",
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

		$inputs["slider_banner_title"]  =  $this->input->post("slider_banner_title");

		$inputs["slider_banner_sub_title"]  =  $this->input->post("slider_banner_sub_title");

		$inputs["slider_banner_detail"]  =  $this->input->post("slider_banner_detail");

		if ($_FILES["slider_banner_image"]["size"] > 0) {
			$inputs["slider_banner_image"]  =  $this->router->fetch_class() . "/" . $this->input->post("slider_banner_image");
		}

		return $this->slider_banner_model->save($inputs);
	}

	public function update_data($slider_banner_id, $image_field = NULL)
	{
		$inputs = array();

		$inputs["slider_banner_title"]  =  $this->input->post("slider_banner_title");

		$inputs["slider_banner_sub_title"]  =  $this->input->post("slider_banner_sub_title");

		$inputs["slider_banner_detail"]  =  $this->input->post("slider_banner_detail");

		if ($_FILES["slider_banner_image"]["size"] > 0) {
			//remove previous file....
			$slider_banners = $this->get_slider_banner($slider_banner_id);
			$file_path = $slider_banners[0]->slider_banner_image;
			$this->delete_file($file_path);
			$inputs["slider_banner_image"]  =  $this->router->fetch_class() . "/" . $this->input->post("slider_banner_image");
		}

		return $this->slider_banner_model->save($inputs, $slider_banner_id);
	}

	//----------------------------------------------------------------
	public function get_slider_banner_list($where_condition = NULL, $pagination = TRUE, $public = FALSE)
	{
		$data = (object) array();
		$fields = array("slider_banners.*");
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
				$this->slider_banner_model->uri_segment = $this->uri->segment(3);
				$config["base_url"]  = base_url($this->uri->segment(1) . "/" . $this->uri->segment(2));
			} else {
				$this->slider_banner_model->uri_segment = $this->uri->segment(4);
				$config["base_url"]  = base_url(ADMIN_DIR . $this->uri->segment(2) . "/" . $this->uri->segment(3));
			}
			$config["total_rows"] = $this->slider_banner_model->joinGet($fields, "slider_banners", $join_table, $where, true);
			$this->pagination->initialize($config);
			$data->pagination = $this->pagination->create_links();
			$data->slider_banners = $this->slider_banner_model->joinGet($fields, "slider_banners", $join_table, $where);
			return $data;
		} else {
			return $this->slider_banner_model->joinGet($fields, "slider_banners", $join_table, $where, FALSE, TRUE);
		}
	}

	public function get_slider_banner($slider_banner_id)
	{

		$fields = array("slider_banners.*");
		$join_table = array();
		$where = "slider_banners.slider_banner_id = $slider_banner_id";

		return $this->slider_banner_model->joinGet($fields, "slider_banners", $join_table, $where, FALSE, TRUE);
	}
}
