<?php
defined('BASEPATH') or exit('No direct script access allowed');
// Don't forget include/define REST_Controller path

/**
 *
 * Controller Employees
 *
 * This controller for ...
 *
 * @package   CodeIgniter
 * @category  Controller CI
 * @author    Setiawan Jodi <jodisetiawan@fisip-untirta.ac.id>
 * @author    Raul Guerrero <r.g.c@me.com>
 * @link      https://github.com/setdjod/myci-extension/
 * @param     ...
 * @return    ...
 *
 */

class Employees extends CI_Controller
{
    
  public function __construct()
  {
    parent::__construct();
    $this->load->model ( 'employees_model', 'emp' );
    include ( APPPATH. 'third_party/bc/BarcodeGenerator.php' ) ;
    include ( APPPATH. 'third_party/bc/BarcodeGeneratorSVG.php' ) ;
  }

  public function index()
  {
    $employees = $this->emp->getEmployees () ;
    $employee  = $employees[0] ;
    print_r ( $employees ) ;
    echo '<br />' ;
    $barcodeGenerator = new \Picqer\Barcode\BarcodeGeneratorSVG () ;
    echo $barcodeGenerator->getBarcode ( '2341682066' , 'C128' ) ;
    echo '<br />' ;
    
  }

}


/* End of file Employees.php */
/* Location: ./app/controllers/Employees.php */