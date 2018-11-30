<?php	// UTF-8 marker äöüÄÖÜß€
/**
 * Class Baecker for the exercises of the EWA lecture
 * Demonstrates use of PHP including class and OO.
 * Implements Zend coding standards.
 * Generate documentation with Doxygen or phpdoc
 * 
 * PHP Version 5
 *
 * @category File
 * @package  Pizzaservice
 * @author   Bernhard Kreling, <b.kreling@fbi.h-da.de> 
 * @author   Ralf Hahn, <ralf.hahn@h-da.de> 
 * @license  http://www.h-da.de  none 
 * @Release  1.2 
 * @link     http://www.fbi.h-da.de 
 */

// to do: change name 'PageTemplate' throughout this file
require_once './Page.php';
require_once './blocks/Baeckerstatus.php';
/**
 * This is a template for top level classes, which represent 
 * a complete web page and which are called directly by the user.
 * Usually there will only be a single instance of such a class. 
 * The name of the template is supposed
 * to be replaced by the name of the specific HTML page e.g. baker.
 * The order of methods might correspond to the order of thinking 
 * during implementation.
 *    private $baeckerstatus;
 
 * @author   Bernhard Kreling, <b.kreling@fbi.h-da.de> 
 * @author   Ralf Hahn, <ralf.hahn@h-da.de> 
 */
class Baecker extends Page
{
    private $baeckerstatus;
    // to do: declare reference variables for members 
    // representing substructures/blocks
    /**
     * Instantiates members (to be defined above).   
     * Calls the constructor of the parent i.e. page class.
     * So the database connection is established.
     *
     * @return none
     */
    protected function __construct() 
    {
        parent::__construct();
        $this->baeckerstatus = new Baeckerstatus($this->_database);
        // to do: instantiate members representing substructures/blocks
    }
    
    /**
     * Cleans up what ever is needed.   
     * Calls the destructor of the parent i.e. page class.
     * So the database connection is closed.
     *
     * @return none
     */
    protected function __destruct() 
    {
        parent::__destruct();
    }

    /**
     * Fetch all data that is necessary for later output.
     * Data is stored in an easily accessible way e.g. as associative array.
     *
     * @return none
     */
    protected function getViewData()
    {
        $stmt = $this->_database->prepare('SELECT
        angebot.name, angebot.id, angebot_bestellung.id,
        angebot_bestellung.status, angebot_bestellung.bestellung_id, bestellung.status
        FROM angebot_bestellung
        INNER JOIN angebot ON angebot.id = angebot_bestellung.angebot_id
                INNER JOIN bestellung
                ON bestellung.id = angebot_bestellung.bestellung_id
        WHERE bestellung.status IS NULL');

      if ($stmt->execute()) {
        $stmt->bind_result($name, $supplyId, $id, $status, $orderId ,$orderstatus);
        $this->_orders = array();

        while ($stmt->fetch()) {
          if (!isset($this->_orders[$orderId])) {
            $this->_orders[$orderId] = array();
          }

          $this->_orders[$orderId][$id] = array(
            'id'     => $supplyId,
            'name'   => $name,
            'status' => $status
          );
        }
      }
    }
    
    /**
     * First the necessary data is fetched and then the HTML is 
     * assembled for output. i.e. the header is generated, the content
     * of the page ("view") is inserted and -if avaialable- the content of 
     * all views contained is generated.
     * Finally the footer is added.
     *
     * @return none
     */
    protected function generateView() 
    {
        $this->getViewData();
        $html = "";

        $scripts = array("css" => array(), "js" => array());
        array_push($scripts['css'], '/ewa/css/baecker.2.css');
        array_push($scripts['css'], '/ewa/css/content.css');
        $html .= $this->generatePageHeader('Bäcker', $scripts);
        $html .=$this->generateNavigation();
        $columns = array('Bestellt', 'Im Ofen', 'Fertig');

        echo'</head><body onload=”javascript:setTimeout(“location.reload(true);”,10000);”>';
        echo'<div class="content">';
        echo'<div class="heading">Bäcker</div>';

        if (empty($this->_orders)) {
            echo '<p>Keine aktiven Pizzen zum backen!</p>' . PHP_EOL;
          } else {

            $url = 'Baecker.php';

            echo '<form action="' . $url . '" method="POST">';
            foreach ($this->_orders as $order) {
                $this->baeckerstatus->generateView($columns, $order, true);
              }
      }
    echo '</form>' . PHP_EOL;
    echo' </div>';
    echo'<script src="js/baecker.js"></script>';
        // to do: call generateView() for all members
        // to do: output view of this page
        $this->generatePageFooter();
        echo $html;
    }
    
    /**
     * Processes the data that comes via GET or POST i.e. CGI.
     * If this page is supposed to do something with submitted
     * data do it here. 
     * If the page contains blocks, delegate processing of the 
	 * respective subsets of data to them.
     *
     * @return none 
     */
    protected function processReceivedData() 
    {
        parent::processReceivedData();
        if (isset($_POST['order'])) {
            $stmt = $this->_database->prepare('UPDATE angebot_bestellung
              SET status = ?
              WHERE id = ?');
  
            foreach ($_POST['order'] as $id => $status) {
              $stmt->bind_param('ii', $status, $id);
              $stmt->execute();
            }
  
            // Check if an order is finished
            $stmt = $this->_database->prepare('SELECT bestellung_id, status
              FROM angebot_bestellung');
  
            if ($stmt->execute()) {
              $orders = array();
  
              $stmt->bind_result($orderId, $status);
  
              while ($stmt->fetch()) {
                // Create entry if not already exists
                if (!isset($orders[$orderId])) {
                  $orders[$orderId] = true;
                }
  
                // Status 2 == finished
                $orders[$orderId] = $orders[$orderId] && $status == 2;
              }
  
              $stmt = $this->_database->prepare('UPDATE bestellung
                SET status = 0
                WHERE id = ? AND status IS NULL');
  
              foreach ($orders as $id => $finished) {
                if ($finished) {
                  $stmt->bind_param('i', $id);
                  $stmt->execute();
                }
              }
            }
          }    }

    /**
     * This main-function has the only purpose to create an instance 
     * of the class and to get all the things going.
     * I.e. the operations of the class are called to produce
     * the output of the HTML-file.
     * The name "main" is no keyword for php. It is just used to
     * indicate that function as the central starting point.
     * To make it simpler this is a static function. That is you can simply
     * call it without first creating an instance of the class.
     *
     * @return none 
     */    
    public static function main() 
    {
        try {
            $page = new Baecker();
            $page->processReceivedData();
            $page->generateView();
        }
        catch (Exception $e) {
            header("Content-type: text/plain; charset=UTF-8");
            echo $e->getMessage();
        }
    }
}

// This call is starting the creation of the page. 
// That is input is processed and output is created.
Baecker::main();

// Zend standard does not like closing php-tag!
// PHP doesn't require the closing tag (it is assumed when the file ends). 
// Not specifying the closing ? >  helps to prevent accidents 
// like additional whitespace which will cause session 
// initialization to fail ("headers already sent"). 
//? >