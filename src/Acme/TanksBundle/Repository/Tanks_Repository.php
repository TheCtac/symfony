<?php
namespace Acme\TanksBundle\Repository;
use Doctrine\ORM\EntityRepository;

class Tanks_Repository extends EntityRepository
{
	public function Findtanks($order,$where,$level)
	{
		$maxRes=4;
		if($where==''){$where='1=1';}
		//if($page==0){$maxRes=999;$page=1;}
		if($level > 0){$where .= 'and t.level ='.$level;}
		return $this->getEntityManager($order)
		->createQuery("SELECT t FROM AcmeTanksBundle:tanks_ t where ".$where." ORDER BY t.".$order." ASC")
		//->setMaxResults($maxRes)
		//->setFirstResult(($page-1)*4)		
        ->getResult();
	}
}