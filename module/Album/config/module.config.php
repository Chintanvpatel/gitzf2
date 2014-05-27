<?php 
return array(
    'controllers' => array(
        'invokables' => array(
            'Album\Controller\Album' => 'Album\Controller\AlbumController',
        	'Album\Controller\AlbumRest' => 'Album\Controller\AlbumRestController',
        ),
    ),
    
    'router' => array(
        'routes' => array(
            'album' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/album[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Album\Controller\Album',
                        'action'     => 'index',
                    ),
                ),
            ),
        		
        		'albumrest' => array(
        				'type'    => 'segment',
        				'options' => array(
        						'route'    => '/albumrest[/:id]',
        						'constraints' => array(
        								'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
        								'id'     => '[0-9]+',
        						),
        						'defaults' => array(
        								'controller' => 'Album\Controller\AlbumRest',
        						),
        				),
        		),
        		'paginator' => array(
        				'type' => 'segment',
        				'options' => array(
        						'route' => '/album[/page/:page][/sort/:sort][/]',
        						'defaults' => array(
        								'page' => 1,
        								'sort' =>'id',
        								'controller' => 'Album\Controller\Album',
        								'action'     => 'index',
        						),
        				),
        		),
        ),
    ),
		
	'service_manager' => array(
			'abstract_factories' => array(
                                'Zend\Db\Adapter\AdapterAbstractServiceFactory',
                        )
	),

    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layoutalbum'           => __DIR__ . '/../view/layout/layoutalbum.phtml',
        ),
        'template_path_stack' => array(
           "Album" => __DIR__ . '/../view',
        ),
    	'strategies' => array(
    		'ViewJsonStrategy',
   		),
    ),
);