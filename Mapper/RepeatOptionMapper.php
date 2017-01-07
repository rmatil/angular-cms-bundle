<?php


namespace rmatil\CmsBundle\Mapper;


use rmatil\CmsBundle\Entity\RepeatOption;
use rmatil\CmsBundle\Exception\MapperException;
use rmatil\CmsBundle\Model\RepeatOptionDTO;

class RepeatOptionMapper extends AbstractMapper {

    /**
     * {@inheritdoc}
     *
     * @return RepeatOptionDTO
     */
    public function entityToDto($repeatOption) {
        if (null === $repeatOption) {
            return null;
        }

        if ( ! ($repeatOption instanceof RepeatOption)) {
            throw new MapperException(sprintf('Required object of type "%s" but got "%s"', RepeatOption::class, get_class($repeatOption)));
        }

        $dto = new RepeatOptionDTO();
        $dto->setId($repeatOption->getId());
        $dto->setOption($repeatOption->getOption());

        return $dto;
    }

    /**
     * {@inheritdoc}
     *
     * @return RepeatOption
     */
    public function dtoToEntity($repeatOptionDto) {
        if (null === $repeatOptionDto) {
            return null;
        }

        if ( ! ($repeatOptionDto instanceof RepeatOptionDTO)) {
            throw new MapperException(sprintf('Required object of type "%s" but got "%s"', RepeatOptionDTO::class, get_class($repeatOptionDto)));
        }

        $entity = new RepeatOption();
        $entity->setId($repeatOptionDto->getId());
        $entity->setOption($repeatOptionDto->getOption());

        return $entity;
    }

    public function entityProvider() {
        $repeatOption = new RepeatOption();
        $repeatOption->setId(1);
        $repeatOption->setOption(RepeatOption::DAILY);

        return [
            [$repeatOption]
        ];
    }

    public function dtoProvider() {
        $dto = new RepeatOptionDTO();
        $dto->setId(3);
        $dto->setOption(RepeatOption::YEARLY);

        return [
            [$dto]
        ];
    }
}
