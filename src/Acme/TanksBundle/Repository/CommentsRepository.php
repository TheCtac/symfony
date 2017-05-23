<?php
namespace Acme\TanksBundle\Repository;
use Doctrine\ORM\EntityRepository;

class CommentsRepository extends EntityRepository
{
	public function findComments($order,$where)
	{
		if($where==''){$where='1=1';}
		return $this->getEntityManager()
		->createQuery("SELECT c,u FROM AcmeTanksBundle:comments c,AcmeTanksBundle:users u where c.user=u.login and 
		".$where." ORDER BY c.".$order." ASC")
		//->createQuery("SELECT c FROM AcmeTanksBundle:comments c where ".$where." ORDER BY c.".$order." ASC")
        ->getResult();
	}
}