<?php
namespace App\Domain\Factories;

use Ramsey\Uuid\Uuid;


use App\Domain\Users\User as UserEntity;
use App\Domain\Users\AdminUser as AdminUserEntity;
use App\Domain\Users\EditorUser as EditorUserEntity;
use App\Domain\Users\MarketerUser as MarketerUserEntity;
use App\Domain\Users\StudentUser as StudentUserEntity;
use App\Domain\Users\TeacherUser as TeacherUserEntity;
use App\Domain\Role as RoleEntity;

use App\Domain\Exceptions\MissingArgumentDomainException;
use App\Domain\Exceptions\InvalidArgumentDomainException;

use App\Domain\Types\UserTypesEnum;
use App\Domain\Types\GenderTypesEnum;

use App\Domain\Factories\IFactory;
use App\Domain\Factories\CourseItemFactory;

use App\Domain\IEntity;
use App\Mappers\CourseItemMapper;





//class UserFactory {
class UserFactory implements IFactory {
    

    public function createObjTree(array $userData) : UserEntity { 
        
        $roleName = null;
        if(!empty($userData) && !empty($userData['roleArr']) && isset($userData['roleArr']['name']))
            $roleName =  $userData['roleArr']['name'];
        
        switch ($roleName) {
            case UserTypesEnum::ADMIN:
                $method     = 'createAdminUserObj';
                break;                
            case UserTypesEnum::EDITOR:
                $method     = 'createEditorUserObj';
                break;                
            case UserTypesEnum::MARKETER:
                $method     = 'createMarketerUserObj';
                break;              
            case UserTypesEnum::STUDENT:
                $method     = 'createStudentUserObj';
                break;                
            case UserTypesEnum::TEACHER:
                $method     = 'createTeacherUserObj';
                break;                
            default:
                $method     = 'createStandardUserObj';
        }

        $userEntity = $this->{$method}($userData);
        return $userEntity;
    }
    
    public function createObj(array $userData) : UserEntity {  
        
        $roleName = null;        
        if(!empty($userData) && !empty($userData['roleArr']) && isset($userData['roleArr']['name']))
            $roleName =  $userData['roleArr']['name'];
                
        switch ($roleName) {
            case UserTypesEnum::ADMIN:
                $method     = 'createAdminUserObj';
                break;                
            case UserTypesEnum::EDITOR:
                $method     = 'createEditorUserObj';
                break;                
            case UserTypesEnum::MARKETER:
                $method     = 'createMarketerUserObj';
                break;              
            case UserTypesEnum::STUDENT:
                $method     = 'createStudentUserObj';
                break;                
            case UserTypesEnum::TEACHER:
                $method     = 'createTeacherUserObj';
                break;                
            default:
                $method     = 'createStandardUserObj';
        }
        $userEntity = $this->{$method}($userData);
        return $userEntity;
    }
    

    private function createStandardUserObj(array $userData): UserEntity {   
        
        if( !isset(
                $userData['fullName'],
                $userData['email'], 
                $userData['phone'],
                $userData['username'],
                $userData['status']
            )
        ){  throw new MissingArgumentDomainException("Missing required parameter for create Standard User");  }
        
        //type validations
        if(!is_string($userData['fullName']) || ($userData['fullName'] === ''))      
            throw new InvalidArgumentDomainException("Invalid fullName parameter to create Standard User entity");             
                
        if(!is_string($userData['phone']) || ($userData['phone'] === ''))      
            throw new InvalidArgumentDomainException("Invalid phone parameter to create Standard User entity");             
        
        if(!is_string($userData['username']) || ($userData['username'] === ''))      
            throw new InvalidArgumentDomainException("Invalid username parameter to create Standard User entity");             
        
        if(!filter_var($userData['email'], FILTER_VALIDATE_EMAIL))    
            throw new InvalidArgumentDomainException("Invalid email address for create Standard User entity");
        
        if(!is_bool($userData['status']))    
            throw new InvalidArgumentDomainException("Invalid status parameter for create Standard User entity");

        $userEntity = new UserEntity(
            $userData['fullName'],
            $userData['email'],
            $userData['phone'],
            $userData['username'],
            $userData['status']
        );
        
        if (!isset($userData['id']) || $userData['id'] == null) {
            $userData['uuid'] = str_replace('-', '', Uuid::uuid4()->toString());
        }

        if (isset($userData['uuid'])) {
            $userEntity->setUuid($userData['uuid']);
        }        

        if (isset($userData['id'])) {
            $userEntity->setId($userData['id']);
        }

        if (isset($userData['profilePic'])) {
            $userEntity->setProfilePic($userData['profilePic']);
        }        

        if (isset($userData['gender'])) {              
            if (!in_array( $userData['gender'], [GenderTypesEnum::MALE, GenderTypesEnum::FEMALE, GenderTypesEnum::OTHER])) {
                throw new InvalidArgumentDomainException('Invalid gender parameter for Standard User entity');
            }
            $userEntity->setGender($userData['gender']);      
        }        

        if (isset($userData['isActivated'])) {              
            if (!is_bool($userData['isActivated']))
                throw new InvalidArgumentDomainException('Invalid isActivated parameter for Standard User entity');
            
            $userEntity->setIsActivated($userData['isActivated']);      
        }

        return $userEntity;
    }

    
    private function createAdminUserObj(array $userData): AdminUserEntity {   
        
        if( !isset(
                $userData['fullName'], 
                $userData['email'], 
                $userData['phone'], 
                $userData['username'],
                $userData['status']
            )
        ){  throw new MissingArgumentDomainException("Missing required parameter for create Admin user entity");    }
        
        //type validations
        if(!is_string($userData['fullName']) || ($userData['fullName'] === ''))      
            throw new InvalidArgumentDomainException("Invalid fullName parameter to create Admin user entity");             
                
        //if(!is_string($userData['phone']) || ($userData['phone'] === ''))      
            //throw new InvalidArgumentDomainException("Invalid phone parameter to create Admin user entity");             
        
        if(!is_string($userData['username']) || ($userData['username'] === ''))      
            throw new InvalidArgumentDomainException("Invalid username parameter to create Admin user entity");             
        
        if(!filter_var($userData['email'], FILTER_VALIDATE_EMAIL))    
            throw new InvalidArgumentDomainException("Invalid email address for create Admin User entity");
        
        if(!is_bool($userData['status']))    
            throw new InvalidArgumentDomainException("Invalid status parameter for create Admin User entity");

        $adminUser = new AdminUserEntity(
            $userData['fullName'],
            $userData['email'],
            $userData['phone'],
            $userData['username'],
            $userData['status']
        );
        
        if (!isset($userData['id']) || $userData['id'] == null) {
            $userData['uuid'] = str_replace('-', '', Uuid::uuid4()->toString());
        }

        if (isset($userData['uuid'])) {
            $adminUser->setUuid($userData['uuid']);
        }        

        if (isset($userData['id'])) {
            $adminUser->setId($userData['id']);
        }

        if (isset($userData['profilePic'])) {
            $adminUser->setProfilePic($userData['profilePic']);
        }        

        if (isset($userData['gender'])) {              
            if (!in_array( $userData['gender'], [GenderTypesEnum::MALE, GenderTypesEnum::FEMALE, GenderTypesEnum::OTHER])) {
                throw new InvalidArgumentDomainException('Invalid gender parameter for Admin User entity');
            }
            $adminUser->setGender($userData['gender']);      
        }        

        if (isset($userData['isActivated'])) {              
            if (!is_bool($userData['isActivated']))
                throw new InvalidArgumentDomainException('Invalid isActivated parameter for Admin User entity');
            
            $adminUser->setIsActivated($userData['isActivated']);      
        }
        
        if(!empty($userData['roleArr']) && $userData['roleArr']['name'] == UserTypesEnum::ADMIN){        
            $role = new RoleEntity($userData['roleArr']['name']);            
            if(isset($userData['roleArr']['id'])) $role->setId($userData['roleArr']['id']);
            if(isset($userData['roleArr']['uuid'])) $role->setUuid($userData['roleArr']['uuid']);
            if($userData['roleArr']['name'] == UserTypesEnum::ADMIN) $role->setSlug($userData['roleArr']['slug']);
            $adminUser->setRole($role);
        }
        
        return $adminUser;
    }


    private function createEditorUserObj(array $userData): EditorUserEntity {   
        
        if( !isset(
                $userData['fullName'], 
                $userData['email'], 
                $userData['phone'], 
                $userData['username'],
                $userData['status']
            )
        ){  throw new MissingArgumentDomainException("Missing required parameter. for create Editor User entity");   }

        //type validations
        if(!is_string($userData['fullName']) || ($userData['fullName'] === ''))      
            throw new InvalidArgumentDomainException("Invalid fullName parameter to create Editor user entity");             
                
        if(!is_string($userData['phone']) || ($userData['phone'] === ''))      
            throw new InvalidArgumentDomainException("Invalid phone parameter to create Editor user entity");             
        
        if(!is_string($userData['username']) || ($userData['username'] === ''))      
            throw new InvalidArgumentDomainException("Invalid username parameter to create Editor user entity");             
        
        if(!filter_var($userData['email'], FILTER_VALIDATE_EMAIL))    
            throw new InvalidArgumentDomainException("Invalid email address for create Editor User entity");
        
        if(!is_bool($userData['status']))    
            throw new InvalidArgumentDomainException("Invalid status parameter for create Editor User entity");

        $editorUser = new EditorUserEntity(
            $userData['fullName'],
            $userData['email'],
            $userData['phone'],
            $userData['username'],
            $userData['status']
        );        

        if (!isset($userData['id']) || $userData['id'] == null) {
            $userData['uuid'] = str_replace('-', '', Uuid::uuid4()->toString());
        }

        if (isset($userData['uuid'])) {
            $editorUser->setUuid($userData['uuid']);
        }
        
        if (isset($userData['id'])) {
            $editorUser->setId($userData['id']);
        }

        if (isset($userData['profilePic'])) {
            $editorUser->setProfilePic($userData['profilePic']);
        }        

        if (isset($userData['gender'])) {              
            if (!in_array( $userData['gender'], [GenderTypesEnum::MALE, GenderTypesEnum::FEMALE, GenderTypesEnum::OTHER])) {
                throw new InvalidArgumentDomainException('Invalid gender parameter for Editor User entity');
            }
            $editorUser->setGender($userData['gender']);      
        }
        
        if (isset($userData['isActivated'])) {              
            if (!is_bool($userData['isActivated']))
                throw new InvalidArgumentDomainException('Invalid isActivated parameter for Editor User entity');
            
            $editorUser->setIsActivated($userData['isActivated']);      
        }

        if(!empty($userData['roleArr']) && $userData['roleArr']['name'] == UserTypesEnum::EDITOR){        
            $role = new RoleEntity($userData['roleArr']['name']);            
            if(isset($userData['roleArr']['id'])) $role->setId($userData['roleArr']['id']);
            if(isset($userData['roleArr']['uuid'])) $role->setUuid($userData['roleArr']['uuid']);
            if($userData['roleArr']['name'] == UserTypesEnum::EDITOR) $role->setSlug($userData['roleArr']['slug']);
            $editorUser->setRole($role);
        }

        return $editorUser;
    }


    private function createMarketerUserObj(array $userData): MarketerUserEntity {   
        
        if( !isset(
                $userData['fullName'], 
                $userData['email'], 
                $userData['phone'], 
                $userData['username'],
                $userData['status']
            )
        ){  throw new MissingArgumentDomainException("Missing required parameter. for create Marketer User"); }
        
        //type validations
        if(!is_string($userData['fullName']) || ($userData['fullName'] === ''))      
            throw new InvalidArgumentDomainException("Invalid fullName parameter to create Marketer user entity");             
                
        if(!is_string($userData['phone']) || ($userData['phone'] === ''))      
            throw new InvalidArgumentDomainException("Invalid phone parameter to create Marketer user entity");             
        
        if(!is_string($userData['username']) || ($userData['username'] === ''))      
            throw new InvalidArgumentDomainException("Invalid username parameter to create Marketer user entity");             
        
        if(!filter_var($userData['email'], FILTER_VALIDATE_EMAIL))    
            throw new InvalidArgumentDomainException("Invalid email address for create Marketer User entity");
        
        if(!is_bool($userData['status']))    
            throw new InvalidArgumentDomainException("Invalid status parameter for create Marketer User entity");

        $marketerUser = new MarketerUserEntity(
            $userData['fullName'],
            $userData['email'],
            $userData['phone'],
            $userData['username'],
            $userData['status']
        );
        
        if (!isset($userData['id']) || $userData['id'] == null) {
            $userData['uuid'] = str_replace('-', '', Uuid::uuid4()->toString());
        }

        if (isset($userData['uuid'])) {
            $marketerUser->setUuid($userData['uuid']);
        }
        
        if (isset($userData['id'])) {
            $marketerUser->setId($userData['id']);
        }

        if (isset($userData['profilePic'])) {
            $marketerUser->setProfilePic($userData['profilePic']);
        }        

        if (isset($userData['gender'])) {              
            if (!in_array( $userData['gender'], [GenderTypesEnum::MALE, GenderTypesEnum::FEMALE, GenderTypesEnum::OTHER])) {
                throw new InvalidArgumentDomainException('Invalid gender parameter for Marketer User entity');
            }
            $marketerUser->setGender($userData['gender']);      
        }
        
        if (isset($userData['isActivated'])){            
            if (!is_bool($userData['isActivated']))
                throw new InvalidArgumentDomainException('Invalid isActivated parameter for Marketer User entity');
            
            $marketerUser->setIsActivated($userData['isActivated']);      
        }

        if(!empty($userData['roleArr']) && $userData['roleArr']['name'] == UserTypesEnum::MARKETER){        
            $role = new RoleEntity($userData['roleArr']['name']);            
            if(isset($userData['roleArr']['id'])) $role->setId($userData['roleArr']['id']);
            if(isset($userData['roleArr']['uuid'])) $role->setUuid($userData['roleArr']['uuid']);
            if($userData['roleArr']['name'] == UserTypesEnum::MARKETER) $role->setSlug($userData['roleArr']['slug']);
            $marketerUser->setRole($role);
        }

        return $marketerUser;
    }

    private function createStudentUserObj(array $userData): StudentUserEntity {   
        
        if( !isset(
                $userData['fullName'], 
                $userData['email'], 
                $userData['phone'], 
                $userData['username'],
                $userData['status']
            )
        ){  throw new MissingArgumentDomainException("Missing required parameter. for create Student User"); }
        
        //type validations
        if(!is_string($userData['fullName']) || ($userData['fullName'] === ''))      
            throw new InvalidArgumentDomainException("Invalid fullName parameter to create Student user entity");             
                
        if(!is_string($userData['phone']) || ($userData['phone'] === ''))      
            throw new InvalidArgumentDomainException("Invalid phone parameter to create Student user entity");             
        
        if(!is_string($userData['username']) || ($userData['username'] === ''))      
            throw new InvalidArgumentDomainException("Invalid username parameter to create Student user entity");             
        
        if(!filter_var($userData['email'], FILTER_VALIDATE_EMAIL))    
            throw new InvalidArgumentDomainException("Invalid email address for create Student User entity");
        
        if(!is_bool($userData['status']))    
            throw new InvalidArgumentDomainException("Invalid status parameter for create Student User entity");

        $studentUser = new StudentUserEntity(
            $userData['fullName'],
            $userData['email'],
            $userData['phone'],
            $userData['username'],
            $userData['status'],
            (int)$userData['dobYear']
        );
        
        if (!isset($userData['id']) || $userData['id'] == null) {
            $userData['uuid'] = str_replace('-', '', Uuid::uuid4()->toString());
        }

        if (isset($userData['uuid'])) {
            $studentUser->setUuid($userData['uuid']);
        }
        
        if (isset($userData['id'])) {
            $studentUser->setId($userData['id']);
        }

        if (isset($userData['profilePic'])) {
            $studentUser->setProfilePic($userData['profilePic']);
        }        

        if (isset($userData['gender'])) {              
            if (!in_array( $userData['gender'], [GenderTypesEnum::MALE, GenderTypesEnum::FEMALE, GenderTypesEnum::OTHER])) {
                throw new InvalidArgumentDomainException('Invalid gender parameter for Student User entity');
            }
            $studentUser->setGender($userData['gender']);      
        }

        /*        
        if (isset($userData['dobYear'])) {
            $studentUser->setDobYear($userData['dobYear']);
        }
        */        

        if (isset($userData['profileText'])) {
            $studentUser->setProfileText($userData['profileText']);
        }
        
        if (isset($userData['isActivated'])){              
            if (!is_bool($userData['isActivated']))
                throw new InvalidArgumentDomainException('Invalid isActivated parameter for Student User entity');
            
            $studentUser->setIsActivated($userData['isActivated']);      
        }

        if(!empty($userData['roleArr']) && $userData['roleArr']['name'] == UserTypesEnum::STUDENT){        
            $role = new RoleEntity($userData['roleArr']['name']);            
            if(isset($userData['roleArr']['id'])) $role->setId($userData['roleArr']['id']);
            if(isset($userData['roleArr']['uuid'])) $role->setUuid($userData['roleArr']['uuid']);
            if($userData['roleArr']['name'] == UserTypesEnum::STUDENT) $role->setSlug($userData['roleArr']['slug']);
            $studentUser->setRole($role);
        }

        /* adding cart items to student entity object */
        if(isset($userData['cartItemsArr']) && is_array($userData['cartItemsArr'])){
            foreach ($userData['cartItemsArr'] as $cartItemData) {
                $courseItemArr      =   CourseItemMapper::dbRecConvertToEntityArr($cartItemData);
                $courseItemEntity   =  (new CourseItemFactory())->createObjTree($courseItemArr);
                $studentUser->addToCart($courseItemEntity);
            }
        }    

        return $studentUser;
    }


    private function createTeacherUserObj(array $userData): TeacherUserEntity {   
        
        if( !isset(
                $userData['fullName'], 
                $userData['email'], 
                $userData['phone'], 
                $userData['username'],
                $userData['status']
            )
        ){  throw new MissingArgumentDomainException("Missing required parameter for create Teacher User entity"); }

        //type validations
        if(!is_string($userData['fullName']) || ($userData['fullName'] === ''))      
            throw new InvalidArgumentDomainException("Invalid fullName parameter to create Teacher user entity");             
                
        if(!is_string($userData['phone']) || ($userData['phone'] === ''))      
            throw new InvalidArgumentDomainException("Invalid phone parameter to create Teacher user entity");             
        
        if(!is_string($userData['username']) || ($userData['username'] === ''))      
            throw new InvalidArgumentDomainException("Invalid username parameter to create Teacher user entity");             
        
        if(!filter_var($userData['email'], FILTER_VALIDATE_EMAIL))    
            throw new InvalidArgumentDomainException("Invalid email address for create Teacher User entity");
        
        if(!is_bool($userData['status']))    
            throw new InvalidArgumentDomainException("Invalid status parameter for create Teacher User entity");

        $teacherUser = new TeacherUserEntity(
            $userData['fullName'],
            $userData['email'],
            $userData['phone'],
            $userData['username'],
            $userData['status'],
            (int)$userData['dobYear']
        );
        
        if (!isset($userData['id']) || $userData['id'] == null) {
            $userData['uuid'] = str_replace('-', '', Uuid::uuid4()->toString());
        }

        if (isset($userData['uuid'])) {
            $teacherUser->setUuid($userData['uuid']);
        }

        if (isset($userData['id'])) {
            $teacherUser->setId($userData['id']);
        }

        if (isset($userData['profilePic'])) {
            $teacherUser->setProfilePic($userData['profilePic']);
        }        

        if (isset($userData['gender'])) {              
            if (!in_array( $userData['gender'], [GenderTypesEnum::MALE, GenderTypesEnum::FEMALE, GenderTypesEnum::OTHER])) {
                throw new InvalidArgumentDomainException('Invalid gender parameter for Teacher User entity');
            }
            $teacherUser->setGender($userData['gender']);      
        }

        if (isset($userData['dobYear'])) {
            $dobYear = $userData['dobYear'];
            if (is_int($dobYear) && ($dobYear >= 1900) && ($dobYear < date('Y'))) {
                $teacherUser->setDobYear($dobYear);
            }else{
                throw new InvalidArgumentDomainException('Invalid dobYear parameter for Teacher User entity');
            }            
        }        
        
        /*
        if (isset($userData['profileText'])) {
            $teacherUser->setProfileText($userData['profileText']);
        }
        */
        
        if (isset($userData['eduQualifications'])) {
            $teacherUser->setEduQualifications($userData['eduQualifications']);
        }

        if (isset($userData['isActivated'])){             
            if (!is_bool($userData['isActivated']))
                throw new InvalidArgumentDomainException('Invalid isActivated parameter for Teacher User entity');
            
            $teacherUser->setIsActivated($userData['isActivated']);      
        }
        
        if(!empty($userData['roleArr']) && $userData['roleArr']['name'] == UserTypesEnum::TEACHER){        
            $role = new RoleEntity($userData['roleArr']['name']);            
            if(isset($userData['roleArr']['id'])) $role->setId($userData['roleArr']['id']);
            if(isset($userData['roleArr']['uuid'])) $role->setUuid($userData['roleArr']['uuid']);
            if($userData['roleArr']['name'] == UserTypesEnum::TEACHER) $role->setSlug($userData['roleArr']['slug']);
            $teacherUser->setRole($role);
        }

        return $teacherUser;
    }
    

}