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

        $this->data['pagebody'] = 'full_booking';
        $this->render();
                
	}

    public function search()
    {
        $day = $this->input->post('day');
        $time = $this->input->post('time');
        $searchDay = $this->timetable->searchByDayOfTheWeek($day, $time);
        $searchCourse = $this->timetable->searchByCourse($day, $time);
        $searchInstructor = $this->timetable->searchByInstructor($day, $time);


    }
       
}
