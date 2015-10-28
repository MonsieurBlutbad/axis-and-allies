<?php
namespace AppBundle\Command;

use AppBundle\Entity\CombinedArm;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use AppBundle\Entity\Unit;

class CreateCombinedArmsCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('battle-calculator:create-combined-arms')
            ->setDescription('Creates units')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var EntityManager $em */
        $em = $this->getContainer()->get('doctrine')->getEntityManager();
        $unitRepo = $em->getRepository('AppBundle\Entity\Unit');
        $combinedArmRepo = $em->getRepository('AppBundle\Entity\CombinedArm');

        $combinedArms = [];

        $combinedArm = new CombinedArm();
        $combinedArm->setName('artillery_and_infantry');
        $combinedArm->setRequires($unitRepo->findOneByName('artillery'));
        $combinedArm->setImproves($unitRepo->findOneByName('infantry'));
        $combinedArm->setAttack(2);
        $combinedArms[] = $combinedArm;

        $combinedArm = new CombinedArm();
        $combinedArm->setName('artillery_and_mechanized_infantry');
        $combinedArm->setRequires($unitRepo->findOneByName('artillery'));
        $combinedArm->setImproves($unitRepo->findOneByName('mechanized_infantry'));
        $combinedArm->setAttack(2);
        $combinedArms[] = $combinedArm;

        $combinedArm = new CombinedArm();
        $combinedArm->setName('tank_and_tactical_bomber');
        $combinedArm->setRequires($unitRepo->findOneByName('tank'));
        $combinedArm->setImproves($unitRepo->findOneByName('tactical_bomber'));
        $combinedArm->setAttack(4);
        $combinedArms[] = $combinedArm;

        $combinedArm = new CombinedArm();
        $combinedArm->setName('fighter_and_tactical_bomber');
        $combinedArm->setRequires($unitRepo->findOneByName('fighter'));
        $combinedArm->setImproves($unitRepo->findOneByName('tactical_bomber'));
        $combinedArm->setAttack(4);
        $combinedArms[] = $combinedArm;

        $combinedArm = new CombinedArm();
        $combinedArm->setName('destroyer_and_fighter');
        $combinedArm->setRequires($unitRepo->findOneByName('destroyer'));
        $combinedArm->setImproves($unitRepo->findOneByName('fighter'));
        $combinedArm->addTag(Unit::CAN_HIT_SUBS);
        $combinedArms[] = $combinedArm;

        $combinedArm = new CombinedArm();
        $combinedArm->setName('destroyer_and_tactical_bomber');
        $combinedArm->setRequires($unitRepo->findOneByName('destroyer'));
        $combinedArm->setImproves($unitRepo->findOneByName('tactical_bomber'));
        $combinedArm->addTag(Unit::CAN_HIT_SUBS);
        $combinedArms[] = $combinedArm;

        $combinedArm = new CombinedArm();
        $combinedArm->setName('destroyer_and_strategic_bomber');
        $combinedArm->setRequires($unitRepo->findOneByName('destroyer'));
        $combinedArm->setImproves($unitRepo->findOneByName('strategic_bomber'));
        $combinedArm->addTag(Unit::CAN_HIT_SUBS);
        $combinedArms[] = $combinedArm;

        foreach($combinedArms as $combinedArm) {
            $oldCombinedArm = $combinedArmRepo->findOneByName($combinedArm->getName());
            if($oldCombinedArm) {
                $output->writeln('Removing ' . $oldCombinedArm->getName());
                $em->remove($oldCombinedArm);
            } else {
                $output->writeln('Persisting Combined Arm ' . $combinedArm->getName());
                $em->persist($combinedArm);
            }
        }

        $em->flush();
        $output->writeln( PHP_EOL . 'Done');
    }

}