<?php

abstract class Person {
    private int $id;
    private string $name;
    private string $email;


    public function __construct($id, $name, $email){
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
    }

    public function getId(){
        return $this->id;
    } 

    public function getName(){
        return $this->name;
    }

    public function getEmail(){
        return $this->email;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function setName($name){
        $this->name = $name;
    }

    public function setEmail($email){
        $this->email = $email;
    }
}

class Student extends Person{
    private int $grade;
    private int $age;

    public function __construct($id, $name, $email, $grade, $age) {
        parent::__construct($id, $name, $email);
        $this->grade = $grade;
        $this->age = $age;
    }

    public function getGrade(){
        return $this->grade;
    }

    public function getAge(){
        return $this->age;
    }

    public function setGrade($grade){
        $this->grade = $grade;
    }

    public function setAge($age){
        $this->age = $age;
    }
}

class Teacher extends Person {
    private string $subject;
    private int $echelle;

    public function __construct($id, $name, $email, $subject, $echelle){
        parent::__construct($id, $name, $email);
        $this->subject = $subject;
        $this->echelle = $echelle;
    }

    public function getSubject(){
        return $this->subject;
    }

    public function getEchelle(){
        return $this->echelle;
    }

    public function setSubject($subject){
        $this->subject = $subject;
    }

    public function setEchelle($echelle){
        $this->echelle = $echelle;
    }
}

$student = new Student(1, "adnane", "adan@gmail.com", 24, 16);
$teacher = new Teacher(1, "sami", "sami@gmail.com", "English", 11);



?>