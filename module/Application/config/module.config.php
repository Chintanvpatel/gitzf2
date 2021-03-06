<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'router' => array(
        'routes' => array(
             'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ), 
        	'userhome' => array(
        			'type' => 'Zend\Mvc\Router\Http\Literal',
        			'options' => array(
        					'route'    => '/user/',
        					'defaults' => array(
        						'controller' => 'Application\Controller\Index',
        						'action'     => 'signin',
        				),
        			),
        		),
        	'album' => array(
        				'type' => 'Zend\Mvc\Router\Http\Literal',
        				'options' => array(
        						'route'    => '/album',
        						'defaults' => array(
        								'controller' => 'Album\Controller\Album',
        								'action'     => 'index',
        						),
        				),
        		),
        	'user' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/user[/:action][/]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'signin',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                		'lang' => array(
                				'type' => 'Segment',
                				'options' => array(
                						'route' => '[:lang][/]',
                						'constraints' => array(
                								'lang' => '[a-zA-Z][a-zA-Z0-9_-]*',
                						),
                						'defaults' => array(
					                       // 'lang' => 'en',
					                    ),
                				),
                		),
                  ),
            ),
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'application' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => 'user',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]][/]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'aliases' => array(	
          'translator' => 'MvcTranslator',
        ),    
    ),
    
    // Gettext translation 
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    
    // PHP Array translation
    
    /* 'translator' => array(
    		'locale' => 'en_US',
    		'translation_file_patterns' => array(
    				array(
    						'type'     => 'phparray',
    						'base_dir' => __DIR__ . '/../language',
    						'pattern'  => '%s.php',
    				),
    		),
    ), */
            
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Index' => 'Application\Controller\IndexController'
        ),
    ),
    
    'controller_plugins' => array(
    		'invokables' => array(
    				'Aclplugin' => 'Application\Controller\Plugin\Aclplugin',
    		)
    ),
    
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
