<?php


namespace rmatil\CmsBundle\Tests\Entity;


use PHPUnit\Framework\TestCase;
use rmatil\CmsBundle\Entity\User;

class UserTest extends TestCase {

    /**
     * @var User
     */
    private $user;

    public function setUp() {
        $this->user = new User();
    }

    /**
     * @dataProvider dataProvider
     */
    public function testAccessors($id, $firstName, $lastName, $phoneNo, $mobileNo, $address, $zipCode, $place, $locked) {
        $this->user->setId($id);
        $this->user->setFirstName($firstName);
        $this->user->setLastName($lastName);
        $this->user->setPhoneNumber($phoneNo);
        $this->user->setMobileNumber($mobileNo);
        $this->user->setAddress($address);
        $this->user->setZipCode($zipCode);
        $this->user->setPlace($place);
        $this->user->setIsAccountLocked($locked);

        $this->assertEquals($id, $this->user->getId());
        $this->assertEquals($firstName, $this->user->getFirstName());
        $this->assertEquals($lastName, $this->user->getLastName());
        $this->assertEquals($phoneNo, $this->user->getPhoneNumber());
        $this->assertEquals($mobileNo, $this->user->getMobileNumber());
        $this->assertEquals($address, $this->user->getAddress());
        $this->assertEquals($zipCode, $this->user->getZipCode());
        $this->assertEquals($place, $this->user->getPlace());
        $this->assertEquals($locked, ! $this->user->isAccountNonLocked());
    }


    public function dataProvider() {
        return [
          [1, 'John', 'Doe', '345678', '873231 1', 'Birmingham Street 2', 'BE', 'Bournemouth', false]
        ];
    }
}
