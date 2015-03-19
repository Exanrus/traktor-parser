<?php
// src/AppBundle/Command/ParseCommand.php
namespace AppBundle\Command;

use AppBundle\Entity\Gamma;
use AppBundle\Entity\Group;
use AppBundle\Entity\Model;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
include('/vendor/simple-html-dom/simple-html-dom/simple_html_dom.php');

class ParseCommand extends ContainerAwareCommand
{
    public $pattern = 'RWhPX3p2S3gWT3Jiakx7XGcBDGIzGhAQeFQGDH1TD1xVDiJeCD0yOztfP2QZEXE9Vg';

    public $baseUrl = 'http://catalogue.extranetsdf.com/eparts.jsp';

    protected function configure()
    {
        $this
            ->setName('parse:start')
            ->setDescription('Parse traktors')
        ;
    }

    private function getGammas($link, OutputInterface $output) {
        $html = file_get_html($link);

        // find all link
        foreach($html->find('[id^=navigazione_tab_]') as $e) {
            foreach($e->find('a') as $a) {
                $pattern = '&PATH=(\d+)\|(\d+)&';
                preg_match($pattern, $a->href, $matches);
                $catalog_id = $matches[1];
                $gamma_id = $matches[2];

                $em = $this->getContainer()->get('doctrine')->getManager();

                $catalog = $em->getRepository('AppBundle:Catalog')->find($catalog_id);
                $gamma = new Gamma();

                $gamma->setCatalog($catalog);
                $gamma->setId($gamma_id);
                $gamma->setName($a->plaintext);
                $gamma->setUrl($a->href);

                $output->writeln($gamma->getUrl());

                $em->persist($gamma);
                $em->flush();

            }
        }
    }

    private function getModels($link, OutputInterface $output) {
        $output->writeln('START LOADING');
        $html = file_get_html($link);
        $output->writeln('LOADED');
        $em = $this->getContainer()->get('doctrine')->getManager();

        $gammaImage = $html->find('img[src*=FamCommerciali]', 0)->src;

        file_put_contents("web/images/".$gammaImage, fopen("http://catalogue.extranetsdf.com/".$gammaImage, 'r'));

        $pattern = '&PATH=(\d+)\|(\d+)&';
        preg_match($pattern, $link, $matches);
        //$output->writeln(print_r($matches, true));
        $gamma_id = $matches[2];
        /** @var Gamma $gamma */
        $gamma = $em->getRepository('AppBundle:Gamma')->find($gamma_id);
        $gamma->setImage($gammaImage);
        $em->persist($gamma);
        $em->flush();

        // find all link
        foreach($html->find('[id^=navigazioneright_tab_]') as $e) {
            foreach($e->find('a') as $a) {
                $pattern = '&PATH=(\d+)\|(\d+)\|(\d+)&';
                preg_match($pattern, $a->href, $matches);
                //$output->writeln(print_r($matches, true));
                $catalog_id = $matches[1];
                $gamma_id = $matches[2];
                $model_id = $matches[3];

                $em = $this->getContainer()->get('doctrine')->getManager();

                $model = new Model();

                $model->setGamma($gamma);
                $model->setId($model_id);
                $model->setName($a->plaintext);
                $model->setUrl($a->href);

                $output->writeln($a->plaintext);

                $em->persist($model);
                //
            }
        }
        $em->flush();

    }

    private function getGroups($link, OutputInterface $output) {
        $output->writeln('Загрузка');
		
		header("Content-type: text/html; charset=utf-8");
		mb_internal_encoding("utf-8");
        $html = file_get_html($link);
        $output->writeln('LOADED');
        $em = $this->getContainer()->get('doctrine')->getManager();

        $pattern = '&PATH=(\d+)\|(\d+)\|(\d+)&';
        preg_match($pattern, $link, $matches);
        //$output->writeln(print_r($matches, true));
        $model_id = $matches[3];
        /** @var Model $model */
        $model = $this->getContainer()->get('doctrine')->getRepository('AppBundle:Model')->find($model_id);

        // find all link
        foreach($html->find('[id^=navigazioneright_tab_]') as $e) {
            foreach($e->find('a') as $a) {
                $pattern = '&PATH=(\d+)\|(\d+)\|(\d+)\|(\d+)&';
                preg_match($pattern, $a->href, $matches);
                //$output->writeln(print_r($matches, true));
                $catalog_id = $matches[1];
                $gamma_id = $matches[2];
                $model_id = $matches[3];
                $group_id = $matches[4];

                $em = $this->getContainer()->get('doctrine')->getManager();

                /** @var Group $group */
                $group = new Group();

                $group->setModel($model);
                $group->setId($group_id);
                $group->setName($a->plaintext);
                $group->setUrl($a->href);

                $output->writeln($a->plaintext);

                $em->persist($group);
                //
            }
        }
        $em->flush();

    }

    private function changeKey($url) {
        
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $link = "http://catalogue.extranetsdf.com/eparts.jsp?PAGE_ID=HOME&VALS=ENGINE_NUMBER:X&CATALOG=DEUT&APP_CONTEXT=CRIC&CULTURE=ru-RU&KEY=R2dBXXgQIR5wKRQEDCodOg1nagRVfHZ2HjJsahs1aTozaEQ4YltUXV05WQJ/dxtbMA&BROWSE_MODE=CURRENT&CLEAR_CACHE=TRUE";

        //$this->getGammas($link, $output);

        /** @var Model $model */
        $model = $this->getContainer()->get('doctrine')->getRepository('AppBundle:Model')->getFirstModel();

        $url = $this->baseUrl.preg_replace('/KEY=(.*?)([^&]+)/','KEY='.$this->pattern,$model->getUrl());

        $this->getGroups($url, $output);

        //$output->writeln(preg_replace('/KEY=(.*?)([^&]+)/','KEY='.$this->pattern,$gamma->getUrl()));
    }
}