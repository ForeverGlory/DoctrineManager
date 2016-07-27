<?php

/*
 * This file is part of the current project.
 * 
 * (c) ForeverGlory <http://foreverglory.me/>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Glory\DoctrineManager;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Description of Manager
 *
 * @author ForeverGlory <foreverglory@qq.com>
 */
class DoctrineManager
{

    /**
     * @var ManagerRegistry 
     */
    protected $registry;
    protected $managerName;
    protected $class;

    /**
     * @var ObjectManager 
     */
    protected $manager;

    /**
     * @var Repository 
     */
    protected $repository;

    public function __construct(ManagerRegistry $registry, $managerName = null)
    {
        $this->registry = $registry;
        $this->managerName = $managerName;
    }

    public function __call($method, $arguments)
    {
        $repository = $this->getRepository();
        return call_user_func_array(array($repository, $method), $arguments);
    }

    public function setClass($class)
    {
        $this->class = $class;
    }

    public function getClass()
    {
        return $this->class;
    }

    public function find($id)
    {
        return $this->getRepository()->find($id);
    }

    public function findAll()
    {
        $this->getRepository()->findAll();
    }

    public function findOneBy($criteria)
    {
        return $this->getRepository()->findOneBy($criteria);
    }

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->getRepository()->findBy($criteria, $orderBy, $limit, $offset);
    }

    public function findOrException($id, $exception)
    {
        $object = $this->find($id);
        if (!$object) {
            throw $exception;
        }
    }

    public function create(array $properties = [])
    {
        $className = $this->getClass();
        $class = new $className();
        $accessor = PropertyAccess::createPropertyAccessor();
        foreach ($properties as $key => $value) {
            $accessor->setValue($class, $key, $value);
        }
        return $class;
    }

    public function update($object, $andFlush = true)
    {
        $this->getManager()->persist($object);
        if ($andFlush) {
            $this->getManager()->flush();
        }
    }

    public function delete($object)
    {
        $this->getManager()->remove($object);
        $this->getManager()->flush();
    }

    /**
     * @return ObjectManager
     */
    public function getManager()
    {
        if (!$this->manager) {
            $this->manager = $this->registry->getManager($this->managerName);
        }
        return $this->manager;
    }

    /**
     * @return ObjectRepository
     */
    public function getRepository()
    {
        if (!$this->repository) {
            $this->repository = $this->registry->getRepository($this->getClass(), $this->managerName);
        }
        return $this->repository;
    }

}
