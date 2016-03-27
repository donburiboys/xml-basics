<?php
    
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Timetable extends CI_Model {
    private $xml = null;
    private $daysofweek = array();
    private $instructors = array();
    private $blocks = array();
    
    public function __construct() {

        $this->xml = simplexml_load_string(file_get_contents('data/timetable.xml'));
        
        foreach ($this->xml->periods->block as $block) {
            foreach ($block->class as $class) {
                $temp = array();
                $temp['time'] = (string) $block['time'];
                $temp['day'] = (string) $class['day'];
                $temp['name'] = (string) $class->name;
                $temp['code'] = (string) $class->code;
                $temp['classinstructor'] = (string) $class->classinstructor;
                $temp['location'] = (string) $class->location;
                $temp['type'] = (string) $class->type;
                $this->blocks[] = new Booking($temp);
            }
        }
        
        foreach ($this->xml->instructors->instructor as $instructor) {
            foreach ($instructor->class as $class) {
                $temp = array();
                $temp['classinstructor'] = (string) $instructor['name'];
                $temp['time'] = (string) $class['time'];  
                $temp['name'] = (string) $class->name;
                $temp['code'] = (string) $class->code;
                $temp['day'] = (string) $class->dayofclass;
                $temp['location'] = (string) $class->location;
                $temp['type'] = (string) $class->type;
                $this->instructors[] = new Booking($temp);
            }
        }
        
        foreach ($this->xml->daysofweek->day as $day) {
            foreach ($day->class as $class) {
                $temp = array();
                $temp['day'] = (string) $day['name'];
                $temp['time'] = (string) $class['time'];  
                $temp['name'] = (string) $class->name;
                $temp['code'] = (string) $class->code;
                $temp['classinstructor'] = (string) $class->classinstructor;
                $temp['location'] = (string) $class->location;
                $temp['type'] = (string) $class->type;
                $this->daysofweek[] = new Booking($temp);
            }
        }
    }
    
    public function getInstructors() {
        return $this->instructors;
    }
    
    public function getDaysOfWeek() {
        return $this->daysofweek;
    }
    
    public function getBlocks() {
        return $this->blocks;
    }

    public function getTheDay()
    {
        $days = array(
            'Monday' => 'Monday',
            'Tuesday' => 'Tuesday',
            'Wednesday' => 'Wednesday',
            'Thursday' => 'Thursday',
            'Friday' => 'Friday'
        );

        return $days;
    }

    public function getTheTimetable()
    {
        $timetable = array (
            '8:30-10:20' => '8:30-10:20',
            '9:30-10:20' => '9:30-10:20',
            '9:30-11:20' => '9:30-11:20',
            '10:30-11:20' => '10:30-11:20',
            '11:30-12:20' => '11:30-12:20',
            '12:30-1:20' => '12:30-1:20',
            '12:30-2:20' => '12:30-2:20',
            '1:30-2:20' => '1:30-2:20',
            '1:30-5:20' => '1:30-5:20',
            '2:30-3:20' => '2:30-3:20',
            '3:30-5:20' => '3:30-5:20'
        );

        return $timetable;
    }

    public function searchByDayOfTheWeek($day, $slot)
    {
        $result = array();

        foreach($this->daysofweek as $booking)
        {
            if($booking->day == $day && $booking->time == $slot)
            {
                array_push($result, $booking);
            }
        }

        return $result;
    }

    public function searchByCourse($day, $slot)
    {
        $result = array();

        foreach($this->code as $booking)
        {
            if($booking->day == $day && $booking->time == $slot)
            {
                array_push($result, $booking);
            }
        }

        return $result;
    }

    public function searchByInstructor($day, $slot)
    {
        $result = array();

        foreach($this->classinstructor as $booking)
        {
            if($booking->day == $day && $booking->time == $slot)
            {
                array_push($result, $booking);
            }
        }

        return $result;
    }
}

class Booking extends CI_Model {
    public $name;
    public $code;
    public $time;
    public $dayofclass;
    public $classinstructor;
    public $location;
    public $type;
    
    public function __construct($booking) {
        
       $this->time = (string) $booking['time'];
       $this->name = (string) $booking['name'];
       $this->code = (string) $booking['code'];
       $this->time = (string) $booking['time'];
       $this->dayofclass = (string) $booking['day'];
       $this->classinstructor = (string) $booking['classinstructor'];
       $this->location = (string) $booking['location'];
       $this->type = (string) $booking['type']; 
    }
    
}
