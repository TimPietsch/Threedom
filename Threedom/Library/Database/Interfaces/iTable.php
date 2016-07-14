<?php
namespace Threedom\Library\Database\Interfaces;

/**
 * Interface for interacting with a specific table in a database
 * 
 * @version 0.1.1b
 * @author Beef
 */
interface iTable {
    
    /* PUBLIC */
    
    /**
     * Creates a new table
     * 
     * @param array $columnList The list of column names and definitions
     * @return boolean <b>true</b> if the table exists after the operation
     */
    public function create($columnList);
    
    /**
     * Drops the selected table
     * 
     * @return boolean <b>true</b> on success, <b>false</b> on failure
     */
    public function drop();
    
    /**
     * Adds a row to the selected table
     * 
     * @param array $valueList The list of values for the new table row
     * @return boolean <b>true</b> on success, <b>false</b> on failure
     */
    public function addRow($valueList);
    
    /**
     * Updates an existing row
     * 
     * @param array $newData The new data
     * @param array $identifier Where the data should go
     * @return boolean <b>true</b> on success, <b>false</b> on failure
     */
    public function updateRow($newData, $identifier);
    
    /**
     * Deletes a row from the table
     * 
     * @param array $identifier Which rows should be deleted
     * @return boolean <b>true</b> on success, <b>false</b> on failure
     */
    public function deleteRow($identifier);
    
    /**
     * Retrieves data from the selected table
     * 
     * The data is returned in a two-dimensional array.
     * 
     * The first index is the number of the row in the results dataset,
     * starting with 0.
     * 
     * The second index is the column name of the respective table field.
     * 
     * @param mixed $columns The columns from where values should be selected. <b>true</b> selects everything, <b>false</b> nothing.
     * @param array $identifier A filter that is applied to selected fields
     * @return array The requested data
     */
    public function readData($columns, $identifier);
    
    /**
     * Return the row count of the table
     * 
     * @return int The number of rows
     */
    public function count();
    
}
