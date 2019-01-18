<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trip_availability extends Admin_Controller {

	public function __construct(){
        parent::__construct();
        $this->load->model('tripavailability_model');
        $this->load->model('destination_model');
        $this->load->model('van_model');
        $this->load->model('rate_model');
    }

    public function index() 
    {
        $data['trips'] = $this->tripavailability_model->all();

		$this->wrapper([
			'view' => 'admin/trip_availability/index',
			'data' => $data
		]);
    }

    public function create()
    {
        $data['destinations'] = $this->destination_model->all();
        $data['vans'] = $this->van_model->all();
        $this->wrapper([
            'view' => 'admin/trip_availability/create',
            'data' => $data
        ]);
    }


    public function store()
    {
        // var_dump($_POST); die();
        $post = $this->input->post();


        $data = $this->format_dates_in_post($post);
        $rates = $data['rates'];
        unset($data['rates']);


        $this->db->trans_begin();
        if($id = $this->tripavailability_model->add($data)){
            foreach($rates as $rate_from_post){
                $this->rate_model->add([
                    'trip_availability_id' => $id,
                    'destination_id' => $rate_from_post['destination_id'],
                    'price' => $rate_from_post['price']
                ]);
            }
            $this->db->trans_commit();
            //set success message
            $alert = [
                'type' => 'success',
                'message' => 'Trip Successfully added.'
            ];
        }else{
            $this->db->trans_rollback();
            //set fail message
            $alert = [
                'type' => 'danger',
                'message' => 'Something went wrong.'
            ];
        }
        
        $this->session->set_flashdata('alert',$alert);
        return redirect(base_url('trip_availability'));

    }

    public function rates($trip_availability_id)
    {
        $trip_availability = $this->tripavailability_model->findById($trip_availability_id);
        $trip_availability = $this->tripavailability_model->initRelations($trip_availability);

        $data['trip_availability'] = $trip_availability;

        $this->wrapper([
            'data' => $data,
            'view' => 'admin/trip_availability/rates/index'
        ]);
    }

    public function edit($id)
    {
        $data['destinations'] = $this->destination_model->all();
        $data['vans'] = $this->van_model->all();
        $trip_availability = $this->tripavailability_model->findById($id);

        // format for repopulating the input fields
        $data['trip_availability'] = $this->tripavailability_model->formatForEdit($trip_availability);

        $this->wrapper([
            'view' => 'admin/trip_availability/edit',
            'data' => $data
        ]);
    }

    public function update($id)
    {
        $post = $this->input->post();
        
        $trip_availability_in_post = $this->format_dates_in_post($post);
        $rates_in_post = $trip_availability_in_post['rates'];

        unset($trip_availability_in_post['rates']); // unset 'rates' cause update does not update relationships

        $trip_availability_in_db = $this->tripavailability_model->initRelations($this->tripavailability_model->findById($id));
        
        //track changes, gets incremented if there's a change
        $changes = 0;
        
        //update trip_availability first
        $this->db->trans_begin();
        $changes += $this->tripavailability_model->update($trip_availability_in_db->id,$trip_availability_in_post);
        
        //compare their destination ids
        $rates_in_db = $trip_availability_in_db->rates;


        $rates_in_post_ids = [];
        foreach($rates_in_post as $rate){    
            //check if rate is already present in db
            $query = $this->db->get_where('rates', [
                'trip_availability_id' => $trip_availability_in_db->id,
                'destination_id' => $rate['destination_id']
                ]);
            $exists = $query->num_rows();
    
            // if exists in db, update existing
            if($exists){
                $rate_in_db = $query->row();
                $changes += $this->rate_model->update($rate_in_db->id,$rate);
            }else{ // if does not exist in db, add new rate
                $rate['trip_availability_id'] = $trip_availability_in_db->id;
                $changes += $this->rate_model->add($rate);
            }
            $rates_in_post_ids[] = $rate['destination_id'];
        }


        foreach($rates_in_db as $rate){
            if(!in_array($rate->destination_id,$rates_in_post_ids)){
                $changes += (Int) $this->rate_model->delete($rate->id);
            }
        }
    
        
        $this->db->trans_complete();
        //set flash alert message if there are changes made
        if($changes){
            $alert = [
                'type' => 'success',
                'message' => 'Trip Availability Updated.'
            ];

            $this->session->set_flashdata('alert',$alert);
        }

        return redirect(base_url('trip_availability'));
    }

    public function format_dates_in_post($post)
    {
        $dt = new DateTimeZone('Asia/Hong_Kong');
        /**
         * DEPARTURE_DATE
         * combine date and time input from post 
         * */
        $rawDeparture = "{$post['departure_date']} {$post['departure_time']}";
        $departure_date = format_date_and_time_for_sql($rawDeparture); // function is in helpers/custom_helper.php

        /**
         * format selling date range
         */
        $rawFrom = "{$post['from']} 00:00:00";
        $rawTo = "{$post['to']} 23:59:59";
        $selling_start = DateTime::createFromFormat('m/d/Y H:i:s',$rawFrom,$dt)->format(DateTime::ISO8601);
        $selling_end = DateTime::createFromFormat('m/d/Y H:i:s',$rawTo,$dt)->format(DateTime::ISO8601);

        $data = [
            'departure_date' => $departure_date,
            'destination_from' => $post['destination_id'],
            'selling_start' => $selling_start,
            'selling_end' => $selling_end,
            'is_roundtrip' => isset($post['is_roundtrip']) ? $post['is_roundtrip'] : 0,
            'van_id' => $post['van_id'],
            'rates' => $post['rates']
        ];

        return $data;
    }

    
    



}
