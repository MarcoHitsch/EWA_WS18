<?php	// UTF-8 marker äöüÄÖÜß€
/**
 * Class BlockTemplate for the exercises of the EWA lecture
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

/**
 * This is a template for classes, which represent div-blocks
 * within a web page. Instances of these classes are used as members
 * of top level classes.
 * The order of methods might correspond to the order of thinking
 * during implementation.

 * @author   Bernhard Kreling, <b.kreling@fbi.h-da.de>
 * @author   Ralf Hahn, <ralf.hahn@h-da.de>
*/

class Navigation
{
    // --- ATTRIBUTES ---

    /**
     * Reference to the MySQLi-Database that is
     * accessed by all operations of the class.
     */
    protected $_database = null;

    // to do: declare reference variables for members
    // representing substructures/blocks

    // --- OPERATIONS ---

    /**
     * Gets the reference to the DB from the calling page template.
     * Stores the connection in member $_database.
     *
     * @param $database $database is the reference to the DB to be used
     *
     * @return none
     */
    public function __construct($database)
    {
        $this->_database = $database;
        // to do: instantiate members representing substructures/blocks
    }

    /**
     * Fetch all data that is necessary for later output.
     * Data is stored in an easily accessible way e.g. as associative array.
     *
     * @return none
     */
    protected function getViewData()
    {
        // to do: fetch data for this view from the database
    }

    function logout()
    {
        session_start();
            header_remove();
            unset($_SESSION['session']);
            session_destroy();
            header("Location: /Index.php");
    }

    /**
     * Generates an HTML block embraced by a div-tag with the submitted id.
     * If the block contains other blocks, delegate the generation of their
	 * parts of the view to them.
     *
     * @param $id $id is the unique (!!) id to be used as id in the div-tag
     *
     * @return none
     */
    public function generateView()
    {
        echo <<<EOF
        <link rel="stylesheet" href="css//nav.css">
        <link rel="stylesheet" href="css//page.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        
        <nav class="navbar">
        <span class="navbar-toggle" id="js-navbar-toggle">
        <!-- <i class="fal fa-bars"></i> -->
        <i class="large material-icons">menu</i>
        </span>
        <a class="logo">PIIIZZAA</a>
        <ul class="main-nav" id='js-menu'>
        
        <li>
        <a href="Bestellung.php" class="nav-links">Bestellung</a>
        </li>
        <li>
        <a href="Baecker.php" class="nav-links">Bäcker</a>
        </li>
        <li>
        <a href="Fahrer.php" class="nav-links">Fahrer</a>
        </li>
        <li>
        <a href="Kunde.php" class="nav-links">Kunde</a>
        </li>
        <li id="logout">
        <a class="nav-links">Logout</a>
        </li>
        
        </ul>
        </nav>
        
        <script>
        document.getElementById("logout").onclick = function() {myFunction()};
        function myFunction() {
          var phpadd= <?php logout();?>
        </script>

EOF;
    }

    /**
     * Processes the data that comes via GET or POST i.e. CGI.
     * If this block is supposed to do something with submitted
     * data do it here.
     * If the block contains other blocks, delegate processing of the
	 * respective subsets of data to them.
     *
     * @return none
     */
    public function processReceivedData()
    {
        // to do: call processData() for all members
    }
}
// Zend standard does not like closing php-tag!
// PHP doesn't require the closing tag (it is assumed when the file ends).
// Not specifying the closing ? >  helps to prevent accidents
// like additional whitespace which will cause session
// initialization to fail ("headers already sent").
//? >
