<?php
    class JobOpening
    {
        private $job_title;
        private $job_description;
        private $contact_info;

        function __construct($job_name, $job_details, $job_contact)
        {
            $this->job_title = $job_name;
            $this->job_description = $job_details;
            $this->contact_info = $job_contact;
        }

        function setTitle($job_name)
        {
            $this->job_title = $job_name;
        }

        function getTitle()
        {
            return $this->job_title;
        }

        function setDescript($job_details)
        {
            $this->job_description = $job_details;
        }

        function getDescript()
        {
            return $this->job_description;
        }

        function setContact($job_contact)
        {
            $this->contact_info = $job_contact;
        }

        function getContact()
        {
            return $this->contact_info;
        }

        function save()
        {
            array_push($_SESSION['available_jobs'], $this);
        }


        static function getAll()
        {
            return $_SESSION['available_jobs'];
        }

        static function deleteAll()
        {
            $_SESSION['available_jobs'] = array();
        }


    }

 ?>
