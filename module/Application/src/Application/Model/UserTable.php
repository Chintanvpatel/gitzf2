<?php

namespace Application\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Authentication\Adapter\DbTable as DbAdapter;
use Zend\Authentication\AuthenticationService as Auth;

class UserTable extends AbstractTableGateway
{
    protected $table = 'user';

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new User());

        $this->initialize();
    }

    public function fetchAll()
    {
        $resultSet = $this->select();
        return $resultSet;
    }

    public function getUser($id)
    {
        $id  = (int) $id;
        $rowset = $this->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveUser(User $user)
    {
        $data = array(
            'fname' => $user->fname,
            'lname'  => $user->lname,
        	'user'  => $user->user,
        	'pass'  => md5($user->pass),
        	'fileupload' => $user->fileupload,
        );

        $id = (int)$user->id;
        if ($id == 0) {
            $this->insert($data);
        } else {
            if ($this->getUser($id)) {
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
    
    public function authUser($user)
    {
    	$dbAdapter = new DbAdapter($this->adapter);
    	
    	$dbAdapter
    	->setTableName('user')
    	->setIdentityColumn('user')
    	->setCredentialColumn('pass')
    	->setCredentialTreatment('MD5(?)')
    	;
    	
    	$dbAdapter
    	->setIdentity($user['username'])
    	->setCredential($user['password'])
    	;
    	
    	$result = $dbAdapter->authenticate($dbAdapter);
    	if($result->isValid()){
    		$authAdapter = new Auth();
    		$storage = $authAdapter->getStorage();
    		$storage->write($dbAdapter->getResultRowObject(array(
    				'user',
    				'fname',
    				'user_level'
    		)));
    		return true;
    	}
    }

}
