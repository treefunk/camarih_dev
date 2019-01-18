<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Availability extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
        $this->load->model('destination_model');
        $this->load->model('tripavailability_model');
        $this->load->model('rate_model');
        $this->load->model('reservation_model');
        $this->load->model('seatplan_model');
    }
    
    // public function index()
    // {
    //     $data[''] = $this->destination_model->all();
    //     return $this->wrapper([
    //         'view' => 'admin//index',
    //         'data' => $data
    //     ]);
    // }

    public function check()
    {
        // destination_from: (string) "4"
        // departure_from: (string) "2019-01-09"
        // destination_to: (string) "3"
        // departure_to: (string) "2019-01-17"
        
   
        /**  prio order 
         *  if post data is set, use post data
         *  if session is set, use session data
         *  if no post/session is set, redirect index page
         */
        if($this->input->post()){
            $post_data = $this->input->post();
        }
        elseif($this->session->has_userdata('check_availability')){
            $post_data = $this->session->userdata('check_availability');
        }else{
            return redirect(base_url());
        }


        

        $data['available_trips'] = $this->tripavailability_model->checkAvailability($post_data);

        $data['selected'] = [
            'from' => $post_data['departure_from'],
            'to' => $post_data['departure_to'],
            'origin' => $this->destination_model->findById($post_data['destination_from']),
            'destination' => $this->destination_model->findById($post_data['destination_to'])
        ];


        $this->session->set_userdata('check_availability', $post_data);

        $this->wrapper([
            'data' => $data,
            'view' => 'check'
        ]);

        
    }

    public function seat_planning()
    {
        
    }

    public function book($rate_id)
    {

        $rate = $this->rate_model->findById($rate_id);
        if($this->session->has_userdata('check_availability')){
            $post_data = $this->session->userdata('check_availability');
        }

        //GET VAN LAYOUT
        $data['seat_map'] = $this->db->select('rates.*, vans.seat_map')
                                     ->from('rates')
                                     ->join('trip_availability','rates.trip_availability_id = trip_availability.id')
                                     ->join('vans','trip_availability.van_id = vans.id')
                                     ->where('rates.id',$rate->id)
                                     ->get()->row()->seat_map;                            
        
        $data['seat_map'] = explode(',',$data['seat_map']);

        //GET OCCUPIED SEATS
        $occupied_seat_map = [];
        $occupied_seats = $this->db->select('seat_plan.*')
                             ->from('seat_plan')
                             ->join('reservations', 'seat_plan.reservation_id = reservations.id')
                             ->join('rates', 'reservations.rate_id = rates.id')
                             ->where('rates.id',$rate->id)
                             ->get()->result();
        foreach($occupied_seats as $occupied_seat){
            $occupied_seat_map[] = (int)$occupied_seat->seat_num;
        }

        $data['occupied_seat_map'] = $occupied_seat_map;
        


        // $data['available_trips'] = $this->tripavailability_model->checkAvailability($post_data);
        $data['selected'] = [
            'from' => $post_data['departure_from'],
            'to' => $post_data['departure_to'],
            'origin' => $this->destination_model->findById($post_data['destination_from']),
            'destination' => $this->destination_model->findById($post_data['destination_to']),
            'rate_id' => $rate->id,
            'rate_price' => $rate->price
        ];

        $data['rate_selected'] = [
            'rate_id' => $rate->id,
            'rate_price' => $rate->price
        ];

        $this->session->set_userdata('selected_rate',$data['rate_selected']);
        $this->session->set_userdata('check_availability', $post_data);



        $this->wrapper([
            'data' => $data,
            'view' => 'book'
        ]);
    }

    public function process_booking()
    {
        $seats = $this->input->post('selected');
        
        if($this->session->has_userdata('selected_rate')){
            $rate_id = $this->session->userdata('selected_rate')['rate_id'];
        }else{
            //todo user hasn't selected a rate!
        }
        //todo validate if seat is still available
        
        //get rate
        $rate = $this->rate_model->findById($rate_id);
        $paid = $this->process_payment();
        if($paid){
            $this->db->trans_begin();
            // Add Reservation
            $reservation = [
                'rate_id' => $rate->id,
            ];

            if($id = $this->reservation_model->add($reservation)){
                foreach($seats as $seat){
                    $seat_plan = [
                        "reservation_id" => $id,
                        "seat_num" => $seat['seat_num'],
                        "name" => $seat['name'],
                        "birth_date" => $seat['bday']
                    ];
                    $this->seatplan_model->add($seat_plan);
                }
            }


        }
        
        
        $this->db->trans_complete();
        if(getenv('DEBUG') == 'true')
        {
            $this->load->view('debug.php',@$data['data']);
            $d = $this->output->enable_profiler(true);
        }
        
    }

    public function process_payment(){
        return TRUE;
    }

}