<?php if (!defined('BASEPATH')) exit('Direct access not allowed!');

class Why_choose_us_model extends MY_Model
{

	public function __construct()
	{

		parent::__construct();
		$this->table = "why_choose_us";
		$this->pk = "why_choose_us_id";
		$this->status = "status";
		$this->order = "order";
	}

	public function validate_form_data()
	{
		$validation_config = array(

			array(
				"field"  =>  "why_choose_us_title",
				"label"  =>  "Why Choose Us Title",
				"rules"  =>  "required"
			),

			array(
				"field"  =>  "why_choose_us_detail",
				"label"  =>  "Why Choose Us Detail",
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

		$inputs["why_choose_us_title"]  =  $this->input->post("why_choose_us_title");

		$inputs["why_choose_us_detail"]  =  $this->input->post("why_choose_us_detail");
		if ($_FILES["attachment"]["size"] > 0) {
			$inputs["attachment"]  =  $this->router->fetch_class() . "/" . $this->input->post("attachment");
		}

		return $this->why_choose_us_model->save($inputs);
	}

	public function update_data($why_choose_us_id, $image_field = NULL)
	{
		$inputs = array();

		$inputs["why_choose_us_title"]  =  $this->input->post("why_choose_us_title");

		$inputs["why_choose_us_detail"]  =  $this->input->post("why_choose_us_detail");

		if ($_FILES["attachment"]["size"] > 0) {
			//remove previous file....
			$why_choose_us = $this->get_why_choose_us($why_choose_us_id);
			$file_path = $why_choose_us[0]->attachment;
			$this->delete_file($file_path);
			$inputs["attachment"]  =  $this->router->fetch_class() . "/" . $this->input->post("attachment");
		}

		return $this->why_choose_us_model->save($inputs, $why_choose_us_id);
	}

	//----------------------------------------------------------------
	public function get_why_choose_us_list($where_condition = NULL, $pagination = TRUE, $public = FALSE)
	{
		$data = (object) array();
		$fields = array("why_choose_us.*");
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
				$this->why_choose_us_model->uri_segment = $this->uri->segment(3);
				$config["base_url"]  = base_url($this->uri->segment(1) . "/" . $this->uri->segment(2));
			} else {
				$this->why_choose_us_model->uri_segment = $this->uri->segment(4);
				$config["base_url"]  = base_url(ADMIN_DIR . $this->uri->segment(2) . "/" . $this->uri->segment(3));
			}
			$config["total_rows"] = $this->why_choose_us_model->joinGet($fields, "why_choose_us", $join_table, $where, true);
			$this->pagination->initialize($config);
			$data->pagination = $this->pagination->create_links();
			$data->why_choose_us = $this->why_choose_us_model->joinGet($fields, "why_choose_us", $join_table, $where);
			return $data;
		} else {
			return $this->why_choose_us_model->joinGet($fields, "why_choose_us", $join_table, $where, FALSE, TRUE);
		}
	}

	public function get_why_choose_us($why_choose_us_id)
	{

		$fields = array("why_choose_us.*");
		$join_table = array();
		$where = "why_choose_us.why_choose_us_id = $why_choose_us_id";

		return $this->why_choose_us_model->joinGet($fields, "why_choose_us", $join_table, $where, FALSE, TRUE);
	}
}
