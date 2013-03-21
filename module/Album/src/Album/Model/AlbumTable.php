<?php

namespace Album\Model;

use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\ResultSet\AbstractResultSet;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\AdapterAwareInterface;
use Album\Entity\Album as AlbumEntity;
use Zend\Stdlib\Hydrator\ClassMethods;

class AlbumTable extends AbstractTableGateway
{
    protected $table = 'album';

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Album());

        $this->initialize();
    }
    
    // Using album entity
    
    /*  public function __construct(Adapter $adapter)
     {
    $this->adapter = $adapter;
    $this->resultSetPrototype = new HydratingResultSet();
    $this->resultSetPrototype->setHydrator(new ClassMethods());
    $this->resultSetPrototype->setObjectPrototype(new AlbumEntity());
    
    $this->initialize();
    }  */
    
    /** Set DbAdapter for model **/
    
    /* public function setDbAdapter(Adapter $adapter)
     {
    $this->adapter = $adapter;
    $this->resultSetPrototype = new HydratingResultSet();
    
    $this->initialize();
    } */

    public function fetchAll($order = 'id')
    {
    	
    	//$data = $this->adapter->query('SELECT * FROM `album`');
    	//print_r($data); exit;
    	 
    	// Using SQL
    	/* $sql = new Sql($this->adapter);
    	 $select = $sql->select();
    	$select->from('album');
    	$select->where(array('id' => 2));
    	//print_r($select);
    	 
    	$statement = $sql->prepareStatementForSqlObject($select);
    	$results = $statement->execute();
    	print_r($results->current()); exit; */
    	 
    	/* $sql = new Sql($this->adapter);
    	$select = $sql->select();
    	$select->from('album');
    	$select->columns(array('album_id'=> new Expression("count(album.id)")));
    	$select->join('user', 'user.id = album.id' , array('fname','lname'),$select::JOIN_LEFT);
    	$select->where(array('album.id'=> 1));
    	//$select->where->like('fname', '%ate%');
    	$statement = $sql->prepareStatementForSqlObject($select);
    	print_r($statement); exit;
    	$results = $statement->execute();
    	print_r($results); exit;   */
    	
        $resultSet = $this->select(function (Select $select) use ($order) {
    		$select->order(array($order => 'DESC')); 		
    	});
    	return $resultSet->toArray();
    }

    public function getAlbum($id)
    {
        $id  = (int) $id;
        $rowset = $this->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveAlbum(Album $album)
    {
    	/** Get array from object **/
        //$data = $album->getArrayFromObject();
        $data = array(
            'artist' => $album->artist,
            'title'  => $album->title,
        ); 

        $id = (int)$album->id;
        if ($id == 0) {
            $this->insert($data);
        } else {
            if ($this->getAlbum($id)) {
                $this->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function deleteAlbum($id)
    {
        $this->delete(array('id' => $id));
    }

}
