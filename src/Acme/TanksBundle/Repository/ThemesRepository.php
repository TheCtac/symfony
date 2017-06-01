<?php
namespace Acme\TanksBundle\Repository;
use Doctrine\ORM\EntityRepository;

class ThemesRepository extends EntityRepository
{
	public function findThemes($order,$where)
	{
		if($where==''){$where='1=1';}
		return $this->getEntityManager()
		->createQuery("SELECT t FROM AcmeTanksBundle:themes t where ".$where." ORDER BY t.".$order." ASC")
        ->getResult();
	}
}