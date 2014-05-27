<?php
/**
 * 
 * @reference : http://hounddog.github.com/blog/getting-started-with-rest-and-zend-framework-2/
 *
 */
namespace Album\Controller;
     
use Zend\Mvc\Controller\AbstractRestfulController;   
use Album\Model\Album;
use Album\Form\AlbumForm;
use Album\Model\AlbumTable;
use Zend\View\Model\JsonModel;
     
class AlbumRestController extends AbstractRestfulController
  {
  	
  	protected $albumTable;
  	
  	/** Get all album data  **/
  	/** $ curl -i -H "Accept: application/json" http://localhost/zf2_example/public/albumrest  **/
    public function getList()
    {
			$results = $this->getAlbumTable()->fetchAll();
			$data = array();
			foreach($results as $result) {
				$data[] = $result;
			}
			 
			return new JsonModel(array(
			'data' => $data,
			));
    }
     
    /** $ curl -i -H "Accept: application/json" http://localhost/zf2_example/public/albumrest  **/
    public function get($id)
    {
    
    }
     
    /**  $ curl -i -H "Accept: application/json" -X POST -d "artist=AC DC&title=Dirty Deeds" http://localhost/zf2_example/public/albumrest  **/
    public function create($data)
    {
    
    }
     
    /** $ curl -i -H "Accept: application/json" -X PUT -d "artist=Ac-Dc&title=Dirty Deeds" http://localhost/zf2_example/public/albumrest  **/
    public function update($id, $data)
    {
    
    }
     
    /** $ curl -i -H "Accept: application/json" -X DELETE http://localhost/zf2_example/public/albumrest **/
    public function delete($id)
    {
    
    }
    
    /** Get model from service manager  **/
    public function getAlbumTable()
    {
        if (!$this->albumTable) {
            $sm = $this->getServiceLocator();
            $this->albumTable = $sm->get('Album\Model\AlbumTable');
        }
        return $this->albumTable;
    }
}
