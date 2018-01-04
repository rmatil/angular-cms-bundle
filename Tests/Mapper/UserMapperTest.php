<?php


namespace rmatil\CmsBundle\Tests\Mapper;


use DateTime;
use PHPUnit\Framework\TestCase;
use rmatil\CmsBundle\Entity\User;
use rmatil\CmsBundle\Mapper\UserMapper;
use rmatil\CmsBundle\Model\UserDTO;

class UserMapperTest extends TestCase {

    /**
     * @var UserMapper
     */
    private $userMapper;

    public function setUp() {
        $this->userMapper = new UserMapper();
    }

    /**
     * @dataProvider entityDataProvider
     *
     * @param $entity User
     */
    public function testToDto($entity) {
        /** @var UserDTO $dto */
        $dto = $this->userMapper->entityToDto($entity);

        $this->assertEquals($entity->getId(), $dto->getId());
        $this->assertEquals($entity->getFirstName(), $dto->getFirstName());
        $this->assertEquals($entity->getLastName(), $dto->getLastName());
        $this->assertEquals($entity->getPhoneNumber(), $dto->getPhoneNumber());
        $this->assertEquals($entity->getMobileNumber(), $dto->getMobileNumber());
        $this->assertEquals($entity->getAddress(), $dto->getAddress());
        $this->assertEquals($entity->getZipCode(), $dto->getZipCode());
        $this->assertEquals($entity->getPlace(), $dto->getPlace());
        $this->assertEquals($entity->getEmail(), $dto->getEmail());
        $this->assertEquals(! $entity->isAccountNonLocked(), $dto->isLocked());
        $this->assertEquals(! $entity->isAccountNonExpired(), $dto->isExpired());
        $this->assertEquals($entity->isEnabled(), $dto->isEnabled());
        $this->assertEquals($entity->getLastLogin(), $dto->getLastLoginDate());
        $this->assertEquals($entity->getRoles(), $dto->getRoles());
    }

    /**
     * @dataProvider dtoDataProvider
     *
     * @param $dto UserDTO
     */
    public function testDtoToEntity($dto) {
        $entity = $this->userMapper->dtoToEntity($dto);

        $this->assertEquals($dto->getId(), $entity->getId());
        $this->assertEquals($dto->getFirstName(), $entity->getFirstName());
        $this->assertEquals($dto->getLastName(), $entity->getLastName());
        $this->assertEquals($dto->getPhoneNumber(), $entity->getPhoneNumber());
        $this->assertEquals($dto->getMobileNumber(), $entity->getMobileNumber());
        $this->assertEquals($dto->getAddress(), $entity->getAddress());
        $this->assertEquals($dto->getZipCode(), $entity->getZipCode());
        $this->assertEquals($dto->getPlace(), $entity->getPlace());
        $this->assertEquals($dto->getEmail(), $entity->getEmail());
        $this->assertEquals(! $dto->isLocked(), $entity->isAccountNonLocked());
        $this->assertEquals(! $dto->isExpired(), $entity->isAccountNonExpired());
        $this->assertEquals($dto->isEnabled(), $entity->isEnabled());
        $this->assertEquals($dto->getLastLoginDate(), $entity->getLastLogin());
        $this->assertEquals($dto->getRoles(), $entity->getRoles());

    }

    public function entityDataProvider() {
        $user = new User();
        $user->setId(1);
        $user->setFirstName('John');
        $user->setLastName('Doe');
        $user->setPhoneNumber('123 456 78');
        $user->setAddress('Some Street 1');
        $user->setZipCode('1234');
        $user->setPlace('some Place');
        $user->setEmail('some@mail.com');
        $user->setLastLogin(new DateTime());

        return [
            [$user]
        ];
    }

    public function dtoDataProvider() {
        $dto = new UserDTO();
        $dto->setId(1);
        $dto->setFirstName('Pony');
        $dto->setLastName('M.');
        $dto->setPhoneNumber('12 34 56');
        $dto->setMobileNumber('123 456');
        $dto->setPlace('Behind the moon');
        $dto->setEmail('moon@rocket.com');
        $dto->setIsLocked(false);
        $dto->setIsEnabled(false);
        $dto->setIsExpired(false);
        $dto->setLastLoginDate(new DateTime());
        // note, fosuserbundle always adds role_user to the entity
        $dto->setRoles(['ROLE_ADMIN', 'ROLE_USER']);

        return [
            [$dto]
        ];
    }
}
