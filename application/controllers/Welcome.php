<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends Application {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
    
    public function __construct() {
        parent::__construct();
    } 
    
    public function index()
    {
        $this->data['blocks'] = $this->timetable->getBlocks();
        $this->data['instructors'] = $this->timetable->getInstructors();
        $this->data['daysofweek'] = $this->timetable->getDaysOfWeek();
        $this->data['dsearch'] = form_dropdown('day',$this->timetable->getTheDay());
        $this->data['tssearch'] = form_dropdown('time',$this->timetable->getTheTimetable());
        $this->data['pagebody'] = 'full_booking';
        $this->render();
    }

    public function search()
    {
        $this->data['courseSearch'] = "";
        $this->data['daySearch'] = "";
        $this->data['instructorSearch'] = "";
        $dayV = $this->input->post('day');
        $timeV = $this->input->post('time');
        $searchDay = $this->timetable->searchByDayOfTheWeek($dayV, $timeV);
        $searchCourse = $this->timetable->searchByCourse($dayV, $timeV);
        $searchInstructor = $this->timetable->searchByInstructor($dayV, $timeV);
        if($searchDay) {
            $this->data['daySearch'] = $this->toString($searchDay);
        }
        if($searchCourse) {
            $this->data['courseSearch'] = $this->toString($searchCourse);
        }
        if($searchInstructor) {
            $this->data['instructorSearch'] = $this->toString($searchInstructor);
        }
        
        $this->data['bingo'] = "NOT A BINGO";
        if($this->data['daySearch'] != "" && 
           $this->data['courseSearch'] != "" && 
           $this->data['instructorSearch'] != "")
        {
            $this->data['bingo'] = "BINGO";
        }
        $this->data['pagebody'] = 'search';
        $this->render();

    }
    public function toString($booking){
        $string = "COURSE: " . $booking->coursename . PHP_EOL  
            . $booking->day  . " : " . $booking->time . PHP_EOL  
            . $booking->instructor . PHP_EOL  
            . $booking->building . " : " . $booking->room . PHP_EOL  
            . $booking->type;
        return $string;
                
    }
    
       
}
