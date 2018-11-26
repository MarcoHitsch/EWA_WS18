<?php	// UTF-8 marker äöüÄÖÜß€
/**
 * Class Kunde for the exercises of the EWA lecture
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
require_once './blocks/Status.php';
/**
 * This is a template for top level classes, which represent 
 * a complete web page and which are called directly by the user.
 * Usually there will only be a single instance of such a class. 
 * The name of the template is supposed
 * to be replaced by the name of the specific HTML page e.g. baker.
 * The order of methods might correspond to the order of thinking 
 * during implementation.
 
 * @author   Bernhard Kreling, <b.kreling@fbi.h-da.de> 
 * @author   Ralf Hahn, <ralf.hahn@h-da.de> 
 */
class Kunde extends Page
{

    /**
     * @var Status
     */
    private $status;

    /**
     * @var array
     */
    private $_order;

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
        $this->status = new Status($this->_database);
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
        if (isset($_SESSION['session'])) {
            $session = $_SESSION['session'];
            $stmt = $this->_database->prepare('SELECT
            angebot.name, angebot.id, angebot_bestellung.id,
            angebot_bestellung.status, angebot_bestellung.bestellung_id, bestellung.status
            FROM angebot_bestellung
            INNER JOIN angebot ON angebot.id = angebot_bestellung.angebot_id
                    INNER JOIN bestellung
                    ON bestellung.id = angebot_bestellung.bestellung_id
            WHERE bestellung.session_id =  ? AND (bestellung.status <=1 || bestellung.status IS NULL)');
                $stmt->bind_param('i', $session);
    
          if ($stmt->execute()) {
            $stmt->bind_result($name, $supplyId, $id, $pizzastatus, $orderId ,$orderstatus);
            $this->_orders = array();
    
            while ($stmt->fetch()) {
              if (!isset($this->_orders[$orderId])) {
                $this->_orders[$orderId] = array();
              }
              $pizzastatus = $orderstatus == 1 ? 3 : $pizzastatus;
              $this->_orders[$orderId][$id] = array(
                'id'     => $supplyId,
                'name'   => $name,
                'status' => $pizzastatus
              );
            }
          }
        }
          else{
            echo'<script>console.log("session NOT set!");</script>'; 
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
        array_push($scripts['css'], '/ewa/css/kunde.css');
        array_push($scripts['css'], '/ewa/css/content.css');

        $html .= $this->generatePageHeader('Kunde', $scripts);
        $html .=$this->generateNavigation();
 

        echo'</head><body>';
        echo'<div class="content">';
        echo'<div class="heading">Kunde</div>';

        if (empty($this->_orders)) {
            echo '<p>Keine aktiven Bestellungen!</p>' . PHP_EOL;
          } else {
            foreach ($this->_orders as $i => $order) {

            $this->status->generateView($order);
            echo '<hr>' . PHP_EOL;
              }
          }
          echo <<<EOF
          <div class="button">
           <a href="Bestellung.php">Neue Bestellung</a>
         </div>
        </div>
EOF;

        // to do: call generateView() for all members
        // to do: output view of this page
        $this->generatePageFooter();
        echo $html;
        echo'<script src="js/kunde.js"></script>';

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
        // to do: call processReceivedData() for all members
    }

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
            $page = new Kunde();
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
Kunde::main();

// Zend standard does not like closing php-tag!
// PHP doesn't require the closing tag (it is assumed when the file ends). 
// Not specifying the closing ? >  helps to prevent accidents 
// like additional whitespace which will cause session 
// initialization to fail ("headers already sent"). 
//? >