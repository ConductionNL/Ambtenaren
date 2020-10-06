<?php

namespace App\DataFixtures;

use App\Entity\JobPosting;
use Conduction\CommonGroundBundle\Service\CommonGroundService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ConductionFixtures extends Fixture
{
    private $params;
    /**
     * @var CommonGroundService
     */
    private $commonGroundService;

    public function __construct(ParameterBagInterface $params, CommonGroundService $commonGroundService)
    {
        $this->params = $params;
        $this->commonGroundService = $commonGroundService;
    }

    public function load(ObjectManager $manager)
    {
        // Lets make sure we only run these fixtures on ZD enviroment
        if (
            !$this->params->get('app_build_all_fixtures') &&
            $this->params->get('app_domain') != 'zuiddrecht.nl' && strpos($this->params->get('app_domain'), 'zuiddrecht.nl') == false &&
            $this->params->get('app_domain') != 'zuid-drecht.nl' && strpos($this->params->get('app_domain'), 'zuid-drecht.nl') == false
        ) {
            return false;
        }
        //var_dump($this->params->get('app_domain'));

        //Test vacature
        $id = Uuid::fromString('3824d042-4b1a-4024-8e83-7943dc9b0e83');
        $jobPosting = new JobPosting();
        $jobPosting->setName('Test Vacature');
        $jobPosting->setDescription('Dit is de beschrijving van deze test vacature');
        $jobPosting->setTitle('Test Vacature');
        $jobPosting->setEmploymentType('full-time');
        $jobPosting->setJobLocationType('TELECOMMUTE');
        $jobPosting->setHiringOrganization($this->commonGroundService->cleanUrl(['component'=>'cc', 'type'=>'organizations', 'id'=>'9650a44d-d7d1-454a-ab4f-2338c90e8c2f']));
        $manager->persist($jobPosting);
        $date = new \DateTime();
        $date->sub(new \DateInterval('P7W'));
        $jobPosting->setJobStartDate($date);
        $jobPosting->setValidThrough($date);
        $jobPosting->setStandardHours('40');
        $manager->persist($jobPosting);
        $jobPosting->setId($id);
        $manager->persist($jobPosting);
        $manager->flush();
        $jobPosting = $manager->getRepository('App:JobPosting')->findOneBy(['id'=> $id]);

        $manager->flush();
    }
}
