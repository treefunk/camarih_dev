<?php

class Tripschedule extends Admin_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model([
            'tripschedule_model'
        ]);
    }

    public function index(){

        $data['schedules'] = $this->tripschedule_model->allByTripNum();

        $this->wrapper([
            'data' => $data,
            'view' => 'admin/schedule/create'
        ]);
    }

    public function update(){
        $post = $this->input->post('schedules');

        //get count of schedules in database
        $schedule_count_db = $this->tripschedule_model->count();
        $schedule_count_post = is_array($post) ? count($post) : 0;

        
        if($schedule_count_post < $schedule_count_db){ // DELETE
            $sched_count_tobe_deleted = $schedule_count_db - $schedule_count_post;
            $schedules = $this->tripschedule_model->allByTripNum('desc');
            for($x = 0 ; $x < $sched_count_tobe_deleted ; $x++){
                $this->tripschedule_model->delete($schedules[$x]->id);
            }

            $alert = [
                'type' => 'success',
                'message' => 'Schedule successfully updated.'
            ];
        }

        if($schedule_count_post > $schedule_count_db){ // ADD
            $sched_count_tobe_added = $schedule_count_post - $schedule_count_db;
            $schedules = $this->tripschedule_model->allByTripNum('desc');
            $new_schedules = array_slice($post,$schedule_count_db,$sched_count_tobe_added);
            foreach($new_schedules as $sched){
                $this->tripschedule_model->add($sched);
            }

            $alert = [
                'type' => 'success',
                'message' => 'Schedule successfully updated.'
            ];
        }

        // update

        if(is_array($post)){
            $schedules = $this->tripschedule_model->allByTripNum();
            for($x = 0 ; $x < count($post); $x++){
                $update = false;
                if($post[$x]['departure_time_pps'] != $schedules[$x]->departure_time_pps ||
                   $post[$x]['departure_time_eln'] != $schedules[$x]->departure_time_eln
                ){
                    $update = true;
                }
    
                if($update){
                    $this->db->update('trip_schedule',$post[$x],['trip_num' => $post[$x]['trip_num']]);
                }
            }

            $alert = [
                'type' => 'success',
                'message' => 'Schedule successfully updated.'
            ];
            
        }

        if(isset($alert)){
            $this->session->set_flashdata('alert',$alert);
        }


        return redirect('tripschedule');
    }
}