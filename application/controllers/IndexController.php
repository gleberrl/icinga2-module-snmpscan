<?php
use Icinga\Web\Controller\ModuleActionController;

class SnmpScan_IndexController extends ModuleActionController
{
    public function indexAction()
    {

 $this->view->application = 'Icinga Web 2';
    $this->view->moreData = array(
//        'Work'   => 'teste',
//	  'Result' => 'aaaaaaa'
    );
    }

}

?>
