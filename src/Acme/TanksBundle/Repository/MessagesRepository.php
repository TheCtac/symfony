<?php
namespace Acme\TanksBundle\Repository;
use Doctrine\ORM\EntityRepository;

class MessagesRepository extends EntityRepository
{
	public function findAllUserMess($where,$order)
	{
		if($where==''){$where = '1=1';}
		if($order==''){$order = 'id';}
		return $this->getEntityManager()
		->createQuery("SELECT m FROM AcmeTanksBundle:messages m where ".$where." ORDER BY m.".$order." ASC ")
		->getResult();
	}
}