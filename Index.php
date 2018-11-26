<?php	// UTF-8 marker äöüÄÖÜß€
/**
 * Class Bestellung for the exercises of the EWA lecture
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

// to do: change name 'Bestellung' throughout this file
require_once './Page.php';

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
class Index extends Page
{
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
        // unset($_SESSION['session']);
        // session_destroy();

        // if (isset($_POST['login'])) {
        //     $_POST['login']= NULL;
        // }
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
    protected function getViewData() { }


    
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
        array_push($scripts['css'], '/ewa/css/login.css');
        array_push($scripts['css'], '/ewa/css/content.css');

        $html .= $this->generatePageHeader('Login', $scripts);
echo <<<EOF
      </head><body>
       <div class="content">
        <div class="heading">PIZZA-SERVICE</div>

        <form action="Index.php" method="post">
            <div id="buttons" class="buttons">
                <input type="submit" class="button" name="login" value="Login" />
            </div>
        </form>

         
EOF;
    echo' </div>';
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
        if (isset($_POST['login'])) {

            // $stmt = $this->_database->prepare('SELECT session_id FROM session');
            // if ($stmt->execute()) {
            //      $stmt->bind_result($session_id);
            //      if($session_id){
            //         $_SESSION['session'] = $session_id + 1;
            //      }
            // }


            if( !isset($_SESSION["session"]) ){
                $session = 1;
                $stmt = $this->_database->prepare('INSERT INTO session
                (session_id) VALUES (?)');
                $stmt->bind_param('i', $session);
            }else{
                $setSession = $_SESSION['session'];
                $setSession = $setSession + 1;
                echo $setSession;   
                $stmt = $this->_database->prepare('INSERT INTO session
                (session_id) VALUES (?)');
                $stmt->bind_param('i', $setSession);
            }
          if ($stmt->execute()) {
              $_SESSION['session'] = $this->_database->insert_id;
            $stmt->close();
            header('Location: Bestellung.php');
          }else{
            echo <<<EOF
            <script type="text/javascript" language="Javascript">  
            alert("Fehler beim login...") 
            </script>  
EOF;
          }


        }
       
    }

    public static function main() 
    {
        try {
            $page = new Index();
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
Index::main();

// Zend standard does not like closing php-tag!
// PHP doesn't require the closing tag (it is assumed when the file ends). 
// Not specifying the closing ? >  helps to prevent accidents 
// like additional whitespace which will cause session 
// initialization to fail ("headers already sent"). 
//? >