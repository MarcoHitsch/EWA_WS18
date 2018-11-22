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

class Warenkorb
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

    /**
     * Generates an HTML block embraced by a div-tag with the submitted id.
     * If the block contains other blocks, delegate the generation of their
	 * parts of the view to them.
     *
     * @param $id $id is the unique (!!) id to be used as id in the div-tag
     *
     * @return none
     */
    public function generateView($id = "", $url)
    {

        $this->getViewData();
        if ($id) {
            $id = "id=\"$id\"";
        }
        echo "<div $id>\n";

        echo <<<EOF
        <div class="cart">
        <form action="{$url}" id="form_order" method="POST" onsubmit="return checkSubmit()">
            <section id="warenkorb">
                <h2>Warenkorb</h2><br>
                <select class="warenkorb" name="orders[]" multiple="multiple" id="warenkorb_select"></select>
                <div><span id="warenkorb_price">0</span> <span> €</span></div>
            </section>
            <section id="adresse">
                <h2>Lieferadresse</h2><br>
                <input class="adressinput" name="adresse" type="text" id="input_adresse" required>
            </section>
            <br />
            <div id="buttons" class="buttons">
                <input type="button" class="button" value="Alle Löschen" id="button_deleteAll">
                <input type="button" class="button" value="Auswahl Löschen" id="button_deleteSelected">
                <input type="submit" class="button" value="Bestellen" id="button_order">
            </div>
        </form>
        </div>
EOF;
        echo "</div>\n";
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
