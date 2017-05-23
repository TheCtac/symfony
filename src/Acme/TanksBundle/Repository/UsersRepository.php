<?php
namespace Acme\TanksBundle\Repository;
use Doctrine\ORM\EntityRepository;

class UsersRepository extends EntityRepository
{
	public function get_user($order,$where)
	{
		if($where==''){$where='1=1';}
		return $this->getEntityManager()
		->createQuery("SELECT u FROM AcmeTanksBundle:users u where ".$where." ORDER BY u.".$order." ASC ")
        ->getResult();
	}
}