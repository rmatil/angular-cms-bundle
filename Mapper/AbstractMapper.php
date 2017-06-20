<?php


namespace rmatil\CmsBundle\Mapper;


abstract class AbstractMapper implements MapperInterface {

    /**
     * {@inheritdoc}
     */
    public function entitiesToDtos(array $entities) : array {
        $dtos = [];

        foreach ($entities as $entity) {
            $dtos[] = $this->entityToDto($entity);
        }

        return $dtos;
    }

    /**
     * {@inheritdoc}
     */
    public function dtosToEntities(array $dtos) : array {
        $entities = [];

        foreach ($dtos as $dto) {
            $entities[] = $this->dtoToEntity($dto);
        }

        return $entities;
    }

    /**
     * {@inheritdoc}
     */
    public abstract function entityToDto($entity);

    /**
     * {@inheritdoc}
     */
    public abstract function dtoToEntity($dto);
}
