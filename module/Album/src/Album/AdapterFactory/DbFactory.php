<?php
namespace Album\AdapterFactory;

use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Album\AdapterFactory\AdapterFactory;

class DbFactory implements AbstractFactoryInterface
{

  protected $modelClasses = array(
           // 'Album\Model\AlbumTable',
           // 'Album\Model\AlbumModel',
        ); 


  /**
     * Determine if we can create a service with name
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @param $name
     * @param $requestedName
     * @return bool
     */
    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
    	return 'AlbumTable';
    }

    /**
     * Create service with name
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @param $name
     * @param $requestedName
     * @return mixed
     */
    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
    	$dbAdapter = $serviceLocator->get('adapter1');
    	$name = 'Album\Model\AlbumTable';
    	return new $name($dbAdapter);
    }
}
