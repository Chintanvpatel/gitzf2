<?php
 
namespace Album\Entity;
 
class Album
{
    protected $id;
 
    protected $artist;
 
    protected $title;
 
    public function getId()
    {
        return $this->id;
    }
 
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
 
    public function getArtist()
    {
        return $this->artist;
    }
 
    public function setArtist($artist)
    {
        $this->artist = $artist;
        return $this;
    }
 
    public function getTitle()
    {
        return $this->title;
    }
 
    public function setTitle($title)
    {
        $this->author = $title;
        return $this;
    }

}
