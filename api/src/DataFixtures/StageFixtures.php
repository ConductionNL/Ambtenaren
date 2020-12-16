<?php

namespace App\DataFixtures;

use App\Entity\Competence;
use App\Entity\Employee;
use App\Entity\JobPosting;
use App\Entity\Skill;
use Conduction\CommonGroundBundle\Service\CommonGroundService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class StageFixtures extends Fixture
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
            $this->params->get('app_domain') != 'zuid-drecht.nl' && strpos($this->params->get('app_domain'), 'zuid-drecht.nl') == false &&
            $this->params->get('app_domain') != 'conduction.academy' && strpos($this->params->get('app_domain'), 'conduction.academy') == false
        ) {
            return false;
        }
        //var_dump($this->params->get('app_domain'));

        //Test employee
        $employee = new Employee();
        $employee->setPerson($this->commonGroundService->cleanUrl(['component'=>'cc', 'type'=>'people', 'id'=>'d961291d-f5c1-46f4-8b4a-6abb41df88db']));
        $employee->setOrganization($this->commonGroundService->cleanUrl(['component' => 'wrc', 'type' => 'organizations', 'id' => 'c571bdad-f34c-4e24-94e7-74629cfaccc9']));
        $manager->persist($employee);
        $manager->flush();

        //Test vacature
        $id = Uuid::fromString('3824d042-4b1a-4024-8e83-7943dc9b0e83');
        $jobPosting = new JobPosting();
        $jobPosting->setName('Test Vacature');
        $jobPosting->setDescription('Dit is de beschrijving van deze test vacature');
        $jobPosting->setTitle('Test Vacature');
        $jobPosting->setEmploymentType('full-time');
        $jobPosting->setJobLocationType('telecommute');
        $jobPosting->setHiringOrganization($this->commonGroundService->cleanUrl(['component' => 'wrc', 'type' => 'organizations', 'id' => 'c571bdad-f34c-4e24-94e7-74629cfaccc9']));
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

        //skills
        $skill = new Skill();
        $skill->setName('php');
        $skill->setDescription('basis php kennis');
        $skill->setLevel('beginner');
        $manager->persist($skill);

        $manager->flush();

        $skill = new Skill();
        $skill->setName('javascript');
        $skill->setDescription('basis javascript kennis');
        $skill->setLevel('beginner');
        $manager->persist($skill);

        $manager->flush();

        //competences
        $competence = new Competence();
        $competence->setName('teamwork');
        $competence->setDescription('hoe goed werk jij in teamverband');
        $competence->setGrade('goed');
        $manager->persist($competence);

        $manager->flush();

        //competences
        $competence = new Competence();
        $competence->setName('plannen');
        $competence->setDescription('hoe goed ben jij in plannen');
        $competence->setGrade('gemiddeld');
        $manager->persist($competence);

        $manager->flush();

        //Full stack developer
        $id = Uuid::fromString('056b486e-d598-47fa-b234-c0323f076a0b');
        $jobPosting = new JobPosting();
        $jobPosting->setName('Full stack developer');
        $jobPosting->setDescription('Lijkt jou het leuk om mee te werken aan super vette projecten waarbij wij de laatste technieken gebruiken? Ben je op zoek naar uitdaging in je werk en wil je je skills een enorme boost geven door het werken met top notch developers? Als jij die gedreven, leergierige en ook een beetje chaos-bestendig bent, dan ben je bij ons aan het juiste adres!  Solliciteer en hopelijk kunnen we je snel verwelkomen in ons team!');
        $jobPosting->setTitle('Full stack developer');
        $jobPosting->setEmploymentType('stage');
        $jobPosting->setJobLocationType('Amsterdam');
        $jobPosting->setEducationRequirements('Waar zijn wij naar op zoek: ', 'Geen 9-5 mentaliteit', 'Duidelijk begrip van wat programmeren inhoudt', 'Ervaring met...', 'Zelfstandig', 'Teamspeler', 'Communicatief vaardig', 'Wat ga je doen: ', 'Programmeren', 'DevOps', 'Serverbeheer', 'Infrastructuur', 'Wat bieden wij: ', 'Gezelligheid', 'Uitdaging', 'Een sterke basis voor je toekomst', 'De nieuwste technieken');
        $jobPosting->setbaseSalary('In overleg');
        $jobPosting->setHiringOrganization($this->commonGroundService->cleanUrl(['component' => 'wrc', 'type' => 'organizations', 'id' => 'c571bdad-f34c-4e24-94e7-74629cfaccc9']));
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
