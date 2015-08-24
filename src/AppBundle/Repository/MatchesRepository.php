<?php

namespace AppBundle\Repository;


class MatchesRepository extends EntityRepository{

    public function fetchAll(){
        return $this->getEntityManager()
             ->createQuery('SELECT m FROM AppBundle:Matches m ORDER BY m.id ASC')
             ->getResult();
    }

    public function getById1Id2($id1,$id2){
        return $this->getEntityManager()
                    ->createQuery('SELECT m FROM AppBundle:Matches m WHERE id1 = ? AND id2 = ?',array($id1,$id2))
                    ->getResult();
    }

    public function updateMatchCountById1Id2($id1,$id2,$count){
        return $this->getEntityManager()
             ->createQuery('UPDATE AppBundle:Matches SET match_count = ? WHERE id1= ? AND id2= ?',array($count,$id1,$id2))
             ->getResult();
    }





}