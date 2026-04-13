<?php


namespace App\Repository;


use App\Entity\Form\MetatagSearch;
use App\Entity\Metatag;
use Doctrine\Persistence\ManagerRegistry;
use Eyetronic\SymfonyMetatagBundle\Repository\MetatagRepository as BaseMetatagRepository;

/**
 * @method Metatag|null find($id, $lockMode = null, $lockVersion = null)
 * @method Metatag|null findOneBy(array $criteria, array $orderBy = null)
 * @method Metatag[]    findAll()
 * @method Metatag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MetatagRepository extends BaseMetatagRepository
{
    public function findAllByLangForm(MetatagSearch $search){
        $result = [];
        if(empty($search->getPattern()) || $search->getPattern() === Metatag::ASTERISK_MASK){
            $result = $this->findBy(['lang' => $search->getLang()]);
        }
        else{
            $qb = $this->createQueryBuilder('m');
            if($search->isPatternHasAsteriskMask()){
                $qb
                    ->where('m.pattern LIKE :pattern')
                    ->setParameters([
                        'pattern' => $search->getNormalizedPattern() . "%"
                    ])
                ;
            }
            else{
                $qb
                    ->where('m.pattern = :pattern')
                    ->orWhere('m.pattern = :patternA')
                    ->setParameters([
                        'pattern' => $search->getPattern(),
                        'patternA' => $search->getPatternAsterisk()
                    ])
                ;
            }
            $qb->orWhere('m.pattern = :a');
            $qb->setParameter('a', Metatag::ASTERISK_MASK);
            $qb->andWhere('m.lang = :lang');
            $qb->setParameter('lang', $search->getLang());
            $result = $qb->getQuery()->getResult();
        }

        return $result;
    }

    public function findAllByLangUrl(MetatagSearch $search){
        $result = [];
        $qb = $this->createQueryBuilder('m');
        if(!empty($search->getUrl())){
            $qb
                ->orWhere('m.pattern = :pattern')
                ->orWhere('m.pattern = :a')
            ;
            $params = [
                'pattern' => $search->getUrl(),
                'a' => Metatag::ASTERISK_MASK,
            ];
            $value = "";
            foreach (str_split($search->getUrl()) as $i => $l){
                $key = 'p' . $i;
                $value .= $l;
                $qb
                    ->orWhere('m.pattern = :' . $key)
                ;
                $params[$key] = $value . "*";
            }
            $qb->setParameters($params);
        }
        else{
            $qb
                ->where('m.pattern = :patternA')
                ->setParameters([
                    'patternA' => Metatag::ASTERISK_MASK,
                ])
            ;
        }

        $qb->andWhere('m.lang = :lang')->setParameter('lang', $search->getLang());

        $result = $qb->getQuery()->getResult();

        return $result;
    }
}