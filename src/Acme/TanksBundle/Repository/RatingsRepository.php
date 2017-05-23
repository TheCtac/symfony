<?php
namespace Acme\TanksBundle\Repository;
use Doctrine\ORM\EntityRepository;

class RatingsRepository extends EntityRepository
{
	public function findAllUserRat($order,$where)
	{
		if($where==''){$where = '1=1';}
		if($order==''){$order = 'user_id';}
		return $this->getEntityManager()
		->createQuery("SELECT r FROM AcmeTanksBundle:ratings r where ".$where." ORDER BY r.".$order." ASC ")
		->getResult();
	}
}