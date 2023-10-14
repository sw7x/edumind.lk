<?php

namespace App\Services\Admin;

use App\Models\ContactUs as ContactUsModel;
use App\Repositories\ContactUsRepository;

use App\DataTransformers\Database\ContactUsMessageDataTransformer;


class ContactUsService
{
    private ContactUsRepository $contactUsRepository;

    public function __construct(ContactUsRepository $contactUsRepository) {
        $this->contactUsRepository = $contactUsRepository;
    }


    public function loadStudentMessages(){
        $studentContactMessages = $this->contactUsRepository->getAllStudentContactMessages();

        $dataArr = array();
        $studentContactMessages->each(function (ContactUsModel $record, int $key) use (&$dataArr){
            $dataArr[] = ContactUsMessageDataTransformer::buildDto($record->toArray());
        });
        return $dataArr;
    }

    public function loadTeacherMessages(){
        $teacherContactMessages = $this->contactUsRepository->getAllTeacherContactMessages();

        $dataArr = array();
        $teacherContactMessages->each(function (ContactUsModel $record, int $key) use (&$dataArr){
            $dataArr[] = ContactUsMessageDataTransformer::buildDto($record->toArray());
        });
        return $dataArr;
    }


    public function loadOtherUserMessages(){
        $otherUserContactMessages = $this->contactUsRepository->getAllOtherUserContactMessages();

        $dataArr = array();
        $otherUserContactMessages->each(function (ContactUsModel $record, int $key) use (&$dataArr){
            $dataArr[] = ContactUsMessageDataTransformer::buildDto($record->toArray());
        });
        return $dataArr;
    }

    public function loadGuestMessages(){
        $guestContactMessages = $this->contactUsRepository->getAllGuestContactMessages();

        $dataArr = array();
        $guestContactMessages->each(function (ContactUsModel $record, int $key) use (&$dataArr){
            $dataArr[] = ContactUsMessageDataTransformer::buildDto($record->toArray());
        });
        return $dataArr;
    }


    public function findContactUsMessageRec(int $id){
        return $this->contactUsRepository->findById($id);
    }

    public function deleteContactUsMessage(int $id){
        return $this->contactUsRepository->deleteById($id);
    }





}


//methods - also in entity
