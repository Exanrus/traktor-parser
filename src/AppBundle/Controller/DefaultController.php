<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Gamma;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

include('/vendor/simple-html-dom/simple-html-dom/simple_html_dom.php');

/**
 * @Route("/")
 * Class DefaultController
 * @package AppBundle\Controller
 */
class DefaultController extends Controller
{
    public $baseLink = "http://catalogue.extranetsdf.com/eparts.jsp";

    private function getGammas($link) {
        $html = file_get_html($link);

        // find all link
        foreach($html->find('[id^=navigazione_tab_]') as $e) {
            foreach($e->find('a') as $a) {
                $pattern = '&PATH=(\d+)\|(\d+)&';
                preg_match($pattern, $a->href, $matches);
                $catalog_id = $matches[1];
                $gamma_id = $matches[2];

                $em = $this->get('doctrine')->getManager();

                $catalog = $em->getRepository('AppBundle:Catalog')->find($catalog_id);
                $gamma = new Gamma();

                $gamma->setCatalog($catalog);
                $gamma->setId($gamma_id);
                $gamma->setName($a->plaintext);
                $gamma->setUrl($a->href);

                $em->persist($gamma);
                $em->flush();

            }
        }
    }

    /**
     * @Route("/xxx", name="homepage")
     * @Template("AppBundle:Default:index.html.twig")
     */
    public function indexAction()
    {
		$link = "http://catalogue.extranetsdf.com/eparts.jsp?PAGE_ID=HOME&VALS=ENGINE_NUMBER:X&CATALOG=DEUT&APP_CONTEXT=CRIC&CULTURE=ru-RU&KEY=R2dBXXgQIR5wKRQEDCodOg1nagRVfHZ2HjJsahs1aTozaEQ4YltUXV05WQJ/dxtbMA&BROWSE_MODE=CURRENT&CLEAR_CACHE=TRUE";

		//$this->getGammas($link);
        $gamma = $this->getDoctrine()->getRepository('AppBundle:Gamma')->getFirstGamma();

        return array(
           'gamma' => $gamma
        );
    }
}
