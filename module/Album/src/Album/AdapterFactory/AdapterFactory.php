<?php
namespace Album\AdapterFactory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\Adapter\Adapter;

class AdapterFactory implements FactoryInterface
{

  protected $configKey;


  // Pass DB config value
  public function __construct($key)
  {
      $this->configKey = $key;
  }

  public function createService(ServiceLocatorInterface $serviceLocator)
  {
      $config = $serviceLocator->get('Config');
      return new Adapter($config[$this->configKey]);
  }
}
