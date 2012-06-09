<?php
namespace TwoKings\Bundle\EBikeBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class EBikeCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('ebike:import')
            ->setDescription('Import CSV')
            ->addArgument('file', InputArgument::OPTIONAL, 'Which file do you want to import?')
            //->addOption('yell', null, InputOption::VALUE_NONE, 'If set, the task will yell in uppercase letters')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $file = $input->getArgument('file');

        if (file_exists($file)) {
            $text = 'Importing file "'.$file.'"..';
            $output->writeln($text);

            $brands = array();
            $bikes  = array();

            $fp = fopen($file,'r');
            $fields = false;
            $cntfld = 0;
            while ($values = fgetcsv($fp,0,';')) {
                if ($fields === false) {
                    $fields = $values;
                    $cntfld = count($fields);
                }
                else {
                    $data = array();
                    for($i=0; $i < $cntfld; $i++) {
                        if ($i < count($values)) {
                            $data[$fields[$i]] = trim($values[$i]);
                        }
                        else {
                            $data[$fields[$i]];
                        }
                    }

                    if (!in_array($data['f_merk'],$brands)) {
                        $brands[] = $data['f_merk'];
                    }

                    $bikes[] = $data;
                }
            }
            fclose($fp);

            $brand_repository = $this->getContainer()->get('doctrine')->getRepository('\TwoKings\Bundle\EBikeBundle\Entity\Brand');
            $em               = $this->getContainer()->get('doctrine')->getEntityManager();
            $flushit          = false;
            foreach($brands as $brand) {
                $brandobject = $brand_repository->findOneBy(array('title'=>$brand));

                if (is_null($brandobject)) {
                    $brandobject = new \TwoKings\Bundle\EBikeBundle\Entity\Brand;

                    $brandobject->setTitle($brand);
                    $brandobject->setPublicid(strtolower($brand));
                    $brandobject->setDateCreated(new \DateTime());
                    $brandobject->setDateModified(new \DateTime());

                    $em->persist($brandobject);
                    $flushit = true;
                }
            }
            if ($flushit) {
                $em->flush();
            }

            foreach($bikes as $bike) {
                $brandobject = $brand_repository->findOneBy(array('title'=>$bike['f_merk']));

                $bikeobject = new \TwoKings\Bundle\EBikeBundle\Entity\Bike;

                $bikeobject->setViewable(true);
                $bikeobject->setPublishState('published');
                $bikeobject->setTitle($bike['f_type']);
                $bikeobject->setAvailable($bike['f_leverbaar'] == 'J');
                $bikeobject->setDateCreated(new \DateTime());
                $bikeobject->setDateModified(new \DateTime());
                $bikeobject->setPrice((int) str_replace(',','.',$bike['f_prijs']) * 100);
                $bikeobject->setYearBuilt((int) str_replace(',','.',$bike['f_modeljaar']));
                $bikeobject->setWeight((int) str_replace(',','.',$bike['f_gewicht']) * 1000);
                $bikeobject->setWeightBattery((int) str_replace(',','.',$bike['f_gewicht accu']) * 1000);
                $bikeobject->setRangeMin((int) $bike['f_bereik_min']);
                $bikeobject->setRangeAvg((int) $bike['f_bereik_avg']);
                $bikeobject->setRangeMax((int) $bike['f_bereik_max']);
                $bikeobject->setBatteryVoltage((int) $bike['f_accu_voltage']);
                $bikeobject->setBatteryAmps((int) $bike['f_accu_amperes']);
                $bikeobject->setEngineLocation((string) $bike['f_motorpositie']);
                $bikeobject->setImageFile((string) $bike['f_beeld_jpg']);
                $bikeobject->setBrochureFile((string) $bike['f_brochure']);
                $bikeobject->setProductUri((string) $bike['f_website']);
                $bikeobject->setInfo((string) $bike['f_info']);
                $bikeobject->setBrand($brandobject);

                $em->persist($bikeobject);
            }
            $em->flush();
        }
        else {
            $text = 'Cannot find file "'.$file.'". Aborted.';
            $output->writeln($text);
        }
    }
}
