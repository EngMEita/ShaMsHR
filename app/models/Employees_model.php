<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 * Model Employees_model
 *
 * This Model for ...
 * 
 * @package		CodeIgniter
 * @category	Model
 * @author    Setiawan Jodi <jodisetiawan@fisip-untirta.ac.id>
 * @link      https://github.com/setdjod/myci-extension/
 * @param     ...
 * @return    ...
 *
 */

class Employees_model extends CI_Model {

  // ------------------------------------------------------------------------

  public function __construct()
  {
    parent::__construct();
  }

  // ------------------------------------------------------------------------


  // ------------------------------------------------------------------------
  public function getEmployees ()
  {
    $this->db->where ( 'is_deleted', 0 );
    $res = $this->db->get ( 'employees' );
    return $res->result ();
  }

  public function getEmployee ( $employee_id )
  {
    $this->db->where ( 'employee_id', $employee_id );
    $res = $this->db->get ( 'employees' );
    return $res->row ();
  }

  public function getAllEmployeeContacts ( $employee_id )
  {
    $cond = array (
      'employee_id' => $employee_id
    );
    $this->db->where ( $cond );
    $res = $this->db->get ( 'employee_contacts' );
    return $res->result ();
  }

  public function getEmployeeContacts ( $employee_id, $is_private = 0 )
  {
    $cond = array (
      'employee_id' => $employee_id,
      'is_private'  => $is_private
    );
    $this->db->where ( $cond );
    $res = $this->db->get ( 'employee_contacts' );
    return $res->result ();
  }

  public function getEmployeeDocs ( $employee_id )
  {
    $cond = array (
      'employee_id' => $employee_id
    );
    $this->db->where ( $cond );
    $res = $this->db->get ( 'employee_docs' );
    return $res->result ();
  }

  public function getEmployeeFamily ( $employee_id )
  {
    $cond = array (
      'employee_id' => $employee_id
    );
    $this->db->where ( $cond );
    $res = $this->db->get ( 'employee_family' );
    return $res->result ();
  }

  public function hasFamily ( $employee_id )
  {
    $family = $this->getEmployeeFamily ( $employee_id );
    foreach ( $family as $member )
    {
      if ( $member->is_in == 1 ) return true;
    }
    return false ;
  }

  public function employeeLastPlan ( $employee_id )
  {
    $cond = array (
      'employee_id' => $employee_id,
      'is_active'   => 1
    );
    $this->db->where ( $cond ) ;
    $this->db->order_by ( 'plan_id', 'DESC' ) ;
    $this->db->limit ( 1 ) ;
    $res = $this->db->get ( 'employee_plans' );
    return $res->row ();
  }

  public function employeeLastPlanDetails ( $employee_id )
  {
    $plan                   = $this->employeeLastPlan ( $employee_id ) ;
    $out_put                = new stdClass () ;
    //$monthOrder             = date ( 'n' ) ;
    $monthOrder             = 12 ;
    $monthFactor            = $monthOrder < 12 ? round ( ( $monthOrder - 1 ) / 12, 4 ) : 1 ;
    $out_put->vacBalance    = floor ( $monthFactor * $plan->vacations_balance ) + $plan->previous_balance - $plan->discounted_balance ;
    $out_put->totalBalance  = $plan->vacations_balance + $plan->previous_balance - $plan->discounted_balance ;
    $out_put->monthlySalary = $plan->monthly_salary ;
    $out_put->dailySalary   = round ( $out_put->monthlySalary / 30, 2 ) ;
    $out_put->hourlySalary  = round ( $out_put->dailySalary / 8, 2 ) ;
    
    return $out_put ;
  }

  


  // ------------------------------------------------------------------------

}

/* End of file Employees_model.php */
/* Location: ./app/models/Employees_model.php */