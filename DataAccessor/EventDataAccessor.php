<?php


namespace rmatil\CmsBundle\DataAccessor;


use DateTime;
use DateTimeZone;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use rmatil\CmsBundle\Constants\EntityNames;
use rmatil\CmsBundle\Entity\EventDetail;
use rmatil\CmsBundle\Entity\File;
use rmatil\CmsBundle\Entity\Location;
use rmatil\CmsBundle\Entity\Offer;
use rmatil\CmsBundle\Entity\RepeatOption;
use rmatil\CmsBundle\Entity\User;
use rmatil\CmsBundle\Exception\EntityInvalidException;
use rmatil\CmsBundle\Exception\EntityNotFoundException;
use rmatil\CmsBundle\Exception\EntityNotInsertedException;
use rmatil\CmsBundle\Exception\EntityNotUpdatedException;
use rmatil\CmsBundle\Mapper\EventMapper;
use rmatil\CmsBundle\Model\EventDTO;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class EventDataAccessor extends DataAccessor {

    protected $eventMapper;

    public function __construct(EntityManagerInterface $em, EventMapper $eventMapper, TokenStorageInterface $tokenStorage, LoggerInterface $logger) {
        parent::__construct(EntityNames::EVENT, $em, $tokenStorage, $logger);

        $this->eventMapper = $eventMapper;
    }

    public function getAll() {
        return $this->eventMapper->entitiesToDtos(parent::getAll());
    }

    public function getById($id) {
        return $this->eventMapper->entityToDto(parent::getById($id));
    }

    public function update($eventDto) {
        if ( ! ($eventDto instanceof EventDTO)) {
            throw new EntityInvalidException(sprintf('Required object of type "%s" but got "%s"', EventDTO::class, get_class($eventDto)));
        }

        $event = $this->eventMapper->dtoToEntity($eventDto);

        /** @var \rmatil\CmsBundle\Entity\Event $dbEvent */
        $dbEvent = $this->em->getRepository(EntityNames::EVENT)->find($event->getId());

        if (null === $dbEvent) {
            throw new EntityNotFoundException(sprintf('Entity "%s" with id "%s" not found', $this->entityName, $event->getId()));
        }

        $user = $this->tokenStorage->getToken()->getUser();
        $dbEvent->setAuthor(
            $this->em->getRepository(EntityNames::USER)->find($user->getId())
        );

        if ($event->getLocation() instanceof Location) {
            $dbEvent->setLocation(
                $this->em->getRepository(EntityNames::LOCATION)->find($event->getLocation()->getId())
            );
        }

        if ($event->getFile() instanceof File) {
            $dbEvent->setFile(
                $this->em->getRepository(EntityNames::FILE)->find($event->getFile()->getId())
            );
        }

        if ($event->getRepeatOption() instanceof RepeatOption) {
            $dbEvent->setRepeatOption(
                $this->em->getRepository(EntityNames::REPEAT_OPTION)->find($event->getRepeatOption()->getId())
            );
        }

        // we persist the detail if it does not exist
        if ($event->getEventDetail() instanceof EventDetail) {
            $eventDetail = $event->getEventDetail();
            $dbDetail = $dbEvent->getEventDetail();

            // nothing found in the database
            if (null === $dbDetail) {
                $eventDetail->setEvent($dbEvent);
                $this->em->persist($eventDetail);
                $dbDetail = $eventDetail;
            }

            // we persist any offer we may have found in the detail...
            $offers = $event->getEventDetail()->getOffers();
            $persistedOffers = new ArrayCollection();
            if ($offers instanceof ArrayCollection) {
                foreach ($offers as $offer) {
                    if ($offer->getId() !== null) {
                        $dbOffer = $this->em->getRepository(Offer::class)->find($offer->getId());

                        // db offer belongs to a different event detail, we may not reassign it
                        if ($dbOffer->getEventDetail()->getId() !== $dbEvent->getEventDetail()->getId()) {
                            $this->logger->critical(sprintf('Offer with id "%s" belongs to another event detail, i.e. "%s". Not reassigning.', $offer->getId(), $dbOffer->getEventDetail()->getId()));
                            $dbOffer = null;
                        }

                        // updating values is permitted here
                        if (null !== $dbOffer) {
                            $dbOffer->setName($offer->getName());
                            $dbOffer->setAmount($offer->getAmount());
                            $dbOffer->setCurrency($offer->getCurrency());
                            $dbOffer->setUrl($offer->getUrl());

                            $persistedOffers->add($dbOffer);
                        }
                    } else {
                        $offer->setEventDetail($dbDetail);
                        $this->em->persist($offer);
                        $persistedOffers->add($offer);
                    }
                }
            }

            $dbOffers = $dbEvent->getEventDetail()->getOffers();
            foreach ($dbOffers as $dbOffer) {
                if (! $persistedOffers->contains($dbOffer)) {
                    // release relation
                    $dbOffer->setEventDetail(null);
                    $this->em->remove($dbOffer);
                }
            }

            $dbEvent->getEventDetail()->setOffers($persistedOffers);

        }

        $allowedUserGroup = $event->getAllowedUserGroup();
        if (null !== $allowedUserGroup) {
            $dbEvent->setAllowedUserGroup(
                $this->em->getRepository(EntityNames::USER_GROUP)->find($event->getAllowedUserGroup()->getId())
            );
        } else {
            $dbEvent->setAllowedUserGroup(null);
        }

        // Note: we prevent updating creation date and url name due to the uniqid
        // stored in url-name. Otherwise, permanent links would fail
        // -> so no update here for this field
        $dbEvent->setLastEditDate(new DateTime());
        $dbEvent->setName($event->getName());
        $dbEvent->setContent($event->getContent());
        $dbEvent->setAdditionalInfo($event->getAdditionalInfo());


        // we get the correct timezone in the request,
        // therefore we only have to apply the utc as timezone
        $utc = new DateTimeZone("UTC");
        if ($event->getStartDate() instanceof DateTime) {
            $event->getStartDate()->setTimezone($utc);
            $dbEvent->setStartDate($event->getStartDate());
        }

        if ($event->getEndDate() instanceof DateTime) {
            $event->getEndDate()->setTimezone($utc);
            $dbEvent->setEndDate($event->getEndDate());
        }

        try {
            $this->em->flush();
        } catch (DBALException $dbalex) {
            $this->logger->error($dbalex);

            throw new EntityNotUpdatedException(sprintf('Could not update entity "%s" with id "%s"', $this->entityName, $event->getId()));
        }

        return $this->eventMapper->entityToDto($dbEvent);
    }

    public function insert($eventDto) {
        if ( ! ($eventDto instanceof EventDTO)) {
            throw new EntityInvalidException(sprintf('Required object of type "%s" but got "%s"', EventDTO::class, get_class($eventDto)));
        }

        $event = $this->eventMapper->dtoToEntity($eventDto);

        $user = $this->tokenStorage->getToken()->getUser();
        $event->setAuthor(
            $this->em->getRepository(EntityNames::USER)->find($user->getId())
        );

        if ($event->getLocation() instanceof Location) {
            $event->setLocation(
                $this->em->getRepository(EntityNames::LOCATION)->find($event->getLocation()->getId())
            );
        }

        if ($event->getFile() instanceof File) {
            $event->setFile(
                $this->em->getRepository(EntityNames::FILE)->find($event->getFile()->getId())
            );
        }

        if ($event->getRepeatOption() instanceof RepeatOption) {
            $event->setRepeatOption(
                $this->em->getRepository(EntityNames::REPEAT_OPTION)->find($event->getRepeatOption()->getId())
            );
        }

        // we persist the detail if it does not exist
        if ($event->getEventDetail() instanceof EventDetail) {
            $eventDetail = $event->getEventDetail();
            $dbDetail = null;
            if ($eventDetail->getId() !== null) {
                $dbDetail = $this->em->getRepository(EventDetail::class)->find($eventDetail->getId());
            }

            // nothing found in the database
            if (null === $dbDetail) {
                $eventDetail->setEvent($event);
                $this->em->persist($eventDetail);
            }

            // we persist any offer we may have found in the detail...
            $offers = $event->getEventDetail()->getOffers();
            $persistedOffers = new ArrayCollection();
            if ($offers instanceof ArrayCollection) {
                foreach ($offers as $offer) {
                    if ($offer->getId() !== null) {
                        $dbOffer = $this->em->getRepository(Offer::class)->find($offer->getId());

                        // db offer belongs to a different event detail, we may not reassign it
                        if ($dbOffer->getEventDetail()->getId() !== $event->getEventDetail()->getId()) {
                            $this->logger->critical(sprintf('Offer with id "%s" belongs to another event detail, i.e. "%s". Not reassigning.', $offer->getId(), $dbOffer->getEventDetail()->getId()));
                            $dbOffer = null;
                        }

                        // updating values is not permitted at all
                        if (null !== $dbOffer) {
                            $persistedOffers->add($dbOffer);
                        }
                    } else {
                        $offer->setEventDetail($event->getEventDetail());
                        $this->em->persist($offer);
                        $persistedOffers->add($offer);
                    }
                }
            }
            $event->getEventDetail()->setOffers($persistedOffers);
        }


        $allowedUserGroup = $event->getAllowedUserGroup();
        if (null !== $allowedUserGroup) {
            $event->setAllowedUserGroup(
                $this->em->getRepository(EntityNames::USER_GROUP)->find($event->getAllowedUserGroup()->getId())
            );
        }

        $event->setCreationDate(new DateTime('now', new DateTimeZone('UTC')));
        $event->setLastEditDate(new DateTime('now', new DateTimeZone('UTC')));

        // we get the correct timezone in the request,
        // therefore we only have to apply the utc as timezone
        $utc = new DateTimeZone("UTC");
        if ($event->getStartDate() instanceof DateTime) {
            $event->getStartDate()->setTimezone($utc);
        }

        if ($event->getEndDate() instanceof DateTime) {
            $event->getEndDate()->setTimezone($utc);
        }

        $uniqid = uniqid();
        $event->setUrlName(sprintf('%s-%s', $event->getUrlName(), $uniqid));

        $this->em->persist($event);

        try {
            $this->em->flush();
        } catch (DBALException $dbalex) {
            $this->logger->error($dbalex);

            throw new EntityNotInsertedException(sprintf('Could not insert entity "%s"', $this->entityName));
        }

        return $this->eventMapper->entityToDto($event);
    }

}
