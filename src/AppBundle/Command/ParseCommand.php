<?php
// src/AppBundle/Command/ParseCommand.php
namespace AppBundle\Command;

use AppBundle\Entity\Gamma;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
include('/vendor/simple-html-dom/simple-html-dom/simple_html_dom.php');

class ParseCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('parse:start')
            ->setDescription('Parse traktors')
        ;
    }

    private function changeKey($url) {
        
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var Gamma $gamma */
        $gamma = $this->getContainer()->get('doctrine')->getRepository('AppBundle:Gamma')->getFirstGamma();
        $output->writeln($gamma->getUrl());
    }
}