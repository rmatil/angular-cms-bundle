<?php


namespace rmatil\CmsBundle\Mapper;


use rmatil\CmsBundle\Entity\User;
use rmatil\CmsBundle\Exception\MapperException;
use rmatil\CmsBundle\Model\UserDTO;

class UserMapper extends AbstractMapper {

    public function entityToDto($user) {
        if (null === $user) {
            return null;
        }

        if ( ! ($user instanceof User)) {
            throw new MapperException(sprintf('Required object of type "%s" but got "%s"', User::class, get_class($user)));
        }

        $userDto = new UserDTO();
        $userDto->setId($user->getId());
        $userDto->setFirstName($user->getFirstName());
        $userDto->setLastName($user->getLastName());
        $userDto->setPhoneNumber($user->getPhoneNumber());
        $userDto->setMobileNumber($user->getMobileNumber());
        $userDto->setAddress($user->getAddress());
        $userDto->setZipCode($user->getZipCode());
        $userDto->setPlace($user->getPlace());
        $userDto->setEmail($user->getEmail());
        $userDto->setIsEnabled($user->isEnabled());
        $userDto->setLastLoginDate($user->getLastLogin());
        $userDto->setRoles($user->getRoles());

        return $userDto;
    }

    public function dtoToEntity($userDto) {
        if (null === $userDto) {
            return null;
        }

        if ( ! ($userDto instanceof UserDTO)) {
            throw new MapperException(sprintf('Required object of type "%s" but got "%s"', UserDTO::class, get_class($userDto)));
        }

        $user = new User();
        $user->setId($userDto->getId());
        $user->setFirstName($userDto->getFirstName());
        $user->setLastName($userDto->getLastName());
        $user->setPhoneNumber($userDto->getPhoneNumber());
        $user->setMobileNumber($userDto->getMobileNumber());
        $user->setAddress($userDto->getAddress());
        $user->setZipCode($userDto->getZipCode());
        $user->setPlace($userDto->getPlace());
        $user->setEmail($userDto->getEmail());
        $user->setIsAccountLocked($userDto->isLocked());
        $user->setEnabled($userDto->isEnabled());
        $user->setLastLogin($userDto->getLastLoginDate());
        $user->setRoles($userDto->getRoles());

        return $user;
    }
}
