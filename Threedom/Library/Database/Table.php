<?php
namespace Threedom\Library\Database;

/**
 * Manages database connections and MySQL queries
 * 
 * This class only provides basic CRUD functionality by design.
 * 
 * This version does not use a shared database connection class or parent object.
 * This is intended for now.
 * 
 * @version 0.3.6beta
 * @author Beef
 */
class Table implements Interfaces\iTable {
    /* PUBLIC */

    /**
     * Connects to the database
     * 
     * The connection is only established for one table. This table
     * cannot be changed. To perform actions on a different table, create
     * a new instance of this class.
     * 
     * If no connection name is provided, it is assumed to be <b>DATABASE</b>.
     * 
     * @throws OutOfBoundsException
     * @param string $tableName The table
     * @param string $connectionName The name of the database connection
     */
    public function __construct($tableName, $connectionName = null) {
        // Get connection settings
        $connectionName = $connectionName ? strtoupper($connectionName) : 'DATABASE';
        
        // Set connection configuration
        $this->_host = defined($connectionName.'_HOST') ? constant($connectionName.'_HOST') : 'localhost';
        $this->_user = constant($connectionName.'_USER');
        $this->_pass = defined($connectionName.'_PASS') ? constant($connectionName.'_PASS') : '';
        $this->_name = constant($connectionName.'_NAME');
        $this->_pref = defined($connectionName.'_PREF') ? constant($connectionName.'_PREF') : $connectionName;
        
        // Connect to database
        $this->_connection = new \mysqli($this->_host, $this->_user, $this->_pass, $this->_name);
        
        // Filter $tableName
        $name = $this->_pref.'_'. preg_replace('/[^a-z_].*?/', '', strtolower((string)$tableName));

        // Determine connection status
        if (!($this->_connection->connect_errno)) {
            $this->_tableName = $name;
        }
        else {
            throw new \OutOfBoundsException($this->_connection->error, $this->_connection->errno);
        }
    }
    
    /**
     * Closes all connections
     * 
     */
    public function __destruct() {
        // Close connections
        $this->_connection->close();
    }
    
    /**
     * Returns the name of the table
     * 
     * @return string The table name
     */
    public function tableName() {
        return $this->_tableName;
    }
    
    /**
     * Creates a table with the currently used table name
     * 
     * The table definition needs to be an <i>array</i> with a <i>colname</i>
     * => <i>definitions</i> format. An indexed array will create default
     * column names.
     * 
     * @param array $columnList The list of column names and definitions
     * @return boolean <b>true</b> on success, <b>true</b> otherwise
     */
    public function create($columnList) {
        // Initialize variables
        $columnList = (array)$columnList;
        
        // Define columns
        $definitions = $this->_defineColumns($columnList);
        
        // Build SQL
        $sql = <<<END_OF_QUERY
CREATE TABLE $this->_tableName
(
$definitions
);
END_OF_QUERY;
        
        // Run query
        return $this->_unprepared($sql) ? true : false;
    }

    /**
     * Drops the declared table, if it existed before
     * 
     * The table will be deleted without checking for references
     * in other tables.
     * 
     * @return boolean <b>true</b> on success, <b>true</b> otherwise
     */
    public function drop() {
        // Build SQL
        $sql = <<<END_OF_QUERY
DROP TABLE IF EXISTS $this->_tableName
END_OF_QUERY;

        // Run query
        return $this->_unprepared($sql) ? true : false;
    }

    /**
     * Adds the provided values as a new row to the specified table
     * 
     * The <i>$valueList</i> argument is interpreted as <i>[column] => [value]</i>.
     * 
     * @param array $valueList The list of values for the new table row
     * @return boolean <b>true</b> on success, <b>false</b> otherwise
     */
    public function addRow($valueList) {
        // Define $columnList
        $columnList = $this->_validateColumns(array_keys((array)$valueList));
        
        // Define $columnNames and $placeholders
        $placeholders = null;
        $columnNames = $this->_clauseListed($columnList, $placeholders);

        // Build SQL
        $sql = <<<END_OF_QUERY
INSERT INTO $this->_tableName
(
$columnNames
)
VALUES
(
$placeholders
)
END_OF_QUERY;

        // Prepare statement
        $this->_prepare($sql);

        // Execute the statement with the values passed to the function
        return $this->_execute($valueList);
    }

    /**
     * Updates the values of all rows matching the identifier
     * 
     * <i>$newData</i> is interpreted as <i>column</i> => <i>value</i>. The
     * value overwrites the old value in the column field of the matching rows.
     * 
     * <i>$identifier</i> is also interpreted as <i>column</i> => <i>value</i>.
     * Multiple pairs are connected with <b>AND</b>, so at the moment a row
     * must match all identifier pairs to be considered a match.
     * 
     * @param array $newData The new data
     * @param array $identifier Where the data should go
     * @return boolean <b>true</b> on success, <b>false</b> on failure
     */
    public function updateRow($newData, $identifier) {
        // Type cast provided arguments
        $newData = (array)$newData;
        
        // Define $columns
        foreach ($newData as $col => $val) {
            if ($col !== 'id') {
                $columns .= $this->_validateColumn($col).' = ?';
                $newValues[] = $val;
            }
        }
        
        // Define $where
        $where = $this->_where($identifier);

        // Build SQL
        $sql = <<<END_OF_QUERY
UPDATE {$this->_tableName}
SET {$columns}
{$where}
END_OF_QUERY;

        // Prepare function
        $this->_prepare($sql);
        
        // Execute the statement with the new values
        return $this->_execute($newValues);
    }

    /**
     * Deletes one or more rows from the table
     * 
     * <i>$identifier</i> is interpreted as <i>column</i> => <i>value</i>.
     * Multiple pairs are connected with <b>AND</b>, so at the moment a row
     * must match all identifier pairs to be considered a match.
     * 
     * @param array $identifier Which rows should be deleted
     * @return boolean <b>true</b> on success, <b>false</b> on failure
     */
    public function deleteRow($identifier) {
        // Define $whereClause
        $where = $this->_where($identifier);

        // Build SQL
        $sql = <<<END_OF_QUERY
DELETE FROM {$this->_tableName}
{$where}
END_OF_QUERY;

        // Prepare function
        $this->_prepare($sql);

        return $this->_execute();
    }

    /**
     * Selects data from the table and returns it as an array
     * 
     * @param mixed $columns The columns from where values should be selected. <b>true</b> selects everything, <b>false</b> nothing.
     * @param array $identifier A filter that is applied to selected fields
     * @return array The selected fields in a two-dimensional array
     */
    public function readData($columns = true, $identifier = true) {
        // Define $columns
        $cols = implode(', ', (array)$this->_validateColumns($columns));
        
        // Define $whereClause
        $where = $this->_where($identifier, 'OR');
        
        // SQL
        $sql = <<<END_OF_QUERY
SELECT {$cols} FROM {$this->_tableName}
{$where}
END_OF_QUERY;
        
        // Run unprepared statement
        $res = $this->_unprepared($sql);
        
        // Return boolean if no rows were requested
        if ($columns === false) {
            $r = $res->fetch_row() ? true : false;
        }
        // Transform into array
        else {
            while ($row = $res->fetch_assoc()) {
                $r[] = $row;
            }
        }
        
        return $r;
    }
    
    /**
     * Return the row count of the table
     * 
     * @return int The number of rows
     */
    public function count() {
        // Build SQL
        $sql = <<<END_OF_QUERY
SELECT COUNT(*) FROM {$this->_tableName}
END_OF_QUERY;
        
        // Run query
        $res = $this->_unprepared($sql);
        
        // Retrieve data
        $row = $res->fetch_array();
        $count = $row[0];
        
        // Return number of rows
        return $count;
    }
    
    /* PRIVATE */
    
    /**
     * @var string The database host
     */
    private $_host;
    /**
     * @var string The database username
     */
    private $_user;
    /**
     * @var string The database password
     */
    private $_pass;
    /**
     * @var string The database name
     */
    private $_name;
    /**
     * @var string The database/table prefix
     */
    private $_pref;
    
    /**
     * Name of the currently used table
     * @var string
     */
    private $_tableName;
    /**
     * The database object
     * @var \mysqli
     */
    private $_connection;
    /**
     * The prepared statement
     * @var \mysqli_stmt
     */
    private $_statement;
    /**
     * The prepares query
     * @var string
     */
    private $_prepared;
    
    /**
     * Returns a partial SQL-clause to be used in MySQL-statements
     * 
     * The <i>values</i> are assumed to be in the correct column order, as
     * only a list without any information about what belongs where is
     * generated.
     * 
     * @access private
     * @param array $values The values in the list
     * @param int <i>$placeholders</i> Will be set to a string with a list of question marks
     * @return string The array values in a list format
     */
    private function _clauseListed($values, &$placeholders = null) {
        // Set placeholders
        for ($i = 0; $i < count($values); $i++) {
            $tmp[] = '?';
        }
        $placeholders = implode(', ', $tmp);
        
        // Return values as a list
        return implode(', ', (array)$values);
    }

    /**
     * Returns a table definition clause
     * 
     * The column definitions are provided as an array in a 
     * <i>columnName => definitions</i> syntax. If an non-string key is
     * detected, a standard name with a <i>col[key]</i> format is used.
     * 
     * A primary key called <i>id</i> is automatically added.
     * 
     * @access private
     * @param array $definitions The column names and definitions
     * @return string The table definition clause
     */
    private function _defineColumns($definitions) {
        // Initialize variables
        $definitions = (array)$definitions;
        $r = "id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,\n";
        
        // Generate $columnDefinitions
        foreach ($definitions as $name => $def) {
            // Determine column name
            $name = $this->_validateColumns($name);

            // Remove unwanted characters from definitions
            $def = strtoupper(preg_replace('/[^\w()_ ].*?/', '', (string)$def));
            
            // Assemble SQL
            $r .= "$name $def,\n";
        }
        
        return $r;
    }
    
    /**
     * Runs an unprepared SQL-query on the database
     * 
     * The query is run directly to the database.
     * 
     * @access private
     * @param string $sql The query
     * @return mixed The result of the query or <b>TRUE</b> on success.
     * @throws \OutOfBoundsException
     */
    private function _unprepared($sql) {
        // Return TRUE on success or a result object
        if ($r = $this->_connection->query((string)$sql)) {
            return $r;
        }
        // FALSE means an error with the database
        else {
            throw new \OutOfBoundsException($this->_connection->error, $this->_connection->errno);
        }
    }

    /**
     * Prepares a MySQL statement to be run repeatedly
     * 
     * The prepared statement is stored in <i>$this->_statement</i>.
     * 
     * @access private
     * @param string $sql The query to be prepared
     * @return bool <b>true</b> on success
     * @throws \OutOfBoundsException
     */
    private function _prepare($sql) {
        if ($sql !== $this->_prepared) {
            if ($this->_statement = $this->_connection->prepare((string)$sql)) {
                // Save query as prepared
                $this->_prepared = $sql;
            }
            else {
                throw new \OutOfBoundsException($this->_connection->error, $this->_connection->errno);
            }
        }
        
        return true;
    }

    /**
     * Executes the prepared statement with the passed values
     * 
     * The values to be used in the prepared statement are considered to be
     * in the right order.
     * 
     * If something other than an array is passed, it's considered to be single
     * value.
     * 
     * @param mixed $values The values
     * @return boolean <b>true</b> on success, <b>false</b> on failure
     */
    private function _execute($values = null) {
        // Create $parameters array
        switch (gettype($values)) {
        case 'array':
            foreach ($values as &$value) {
                $params[0] .= 's'; // Everything is passed to MySQL as string
                if ($value === null || $value === '') {
                    $value = null;
                }
                $params[] = &$value; // to bind the parameters, references are needed!
            }
            break;

        case 'NULL':
            break;

        default:
            $params[0] = 's'; // Everything is passed to MySQL as string
            if ($values === null || $values === '') {
                $values = null;
            }
            $params[1] = &$values; // to bind the parameters, references are needed!
            break;
        }

        // Bind parameters to placeholders in prepared statement
        call_user_func_array(array($this->_statement, 'bind_param'), $params); // call_user_func_array for variable number of parameters

        // Execute the statement
        return $this->_statement->execute();
    }
    
    /**
     * Returns a validated column name
     * 
     * If the provided argument is an <i>integer</i>, a column name with a
     * col<i>[int]</i> format is generated.
     * 
     * If the provided argument is a <i>string</i>, the valid column name
     * is also returned as a string. It is the given string, sanitized.
     * 
     * @access private
     * @param mixed $name The proposed column name
     * @return string The valid column name
     */
    private function _validateColumn($name) {
        switch(gettype($name)) {
            case 'integer':
                $r = 'col'.$name;
                break;
            case 'string':
                $r = preg_replace('/[^\w_].*?/', '', $name);
                break;
        }
        
        return $r;
    }
    
    /**
     * Returns validated column names
     * 
     * If the provided argument is a <i>boolean</i>, the valid column name
     * is returned as a <i>string</i>:
     * - <b>true</b> validates to <b>*</b>
     * - <b>false</b> validates to <b>1</b>
     * 
     * If the provided argument is a <i>string</i>, the valid column name
     * is also returned as a string. It is the given string, sanitized.
     * 
     * If the provided argument is an <i>array</i>, the valid column names
     * are also returned in an array. String values are sanitized, integer
     * values are returned as string in the format: col[int].
     * 
     * If another type is provided in the argument, <b>null</b> is returned.
     * 
     * @access private
     * @param mixed $columns The proposed, maybe invalid column names. Can be <b>boolean</b>, <b>string</b> or <b>array</b>.
     * @return mixed The valid column names, mostly as an array.
     */
    private function _validateColumns($columns) {
        // Check given argument type
        $r = null;
        switch (gettype($columns)) {
            // All columns or none
            case 'boolean':
                $r = $columns ? '*' : '1';
                break;

            // Multiple specified columns
            case 'array':
                foreach ($columns as $col) {
                    $r[] = $this->_validateColumn($col);
                }
                break;

            default:
                $r = $this->_validateColumn($columns);
                break;
        }

        return $r;
    }

    /**
     * Returns a valid clause to use in a WHERE SQL-statement
     * 
     * @access private
     * @param mixed $identifier Interpreted as <i>column</i> => <i>value</i> or <b>true</b>, meaning everything.
     * @param string $operator Optional. An operator to connect multiple clauses with. Default is <b>AND</b>.
     * @return string The clause
     */
    private function _where($identifier, $operator = 'AND') {
        // Set tautology on true
        if ($identifier === true) {
            $identifier = array(
                'NULL' => ''
            );
        }
        
        // create part clauses
        foreach ($identifier as $col => $val) {
            // column
            $col = $this->_validateColumn($col);

            // adjust of value formatting for SQL
            if (is_bool($val)) {
                $comp = '=';
                $val = $val ? '1' : '0';
            }
            elseif (is_null($val) || $val === '') {
                $comp = 'IS';
                $val = 'NULL';
            }
            else {
                $comp = '=';
                $val = "'{$this->_connection->real_escape_string((string)$val)}'";
            }
            $clauses[] = $col.' '.$comp.' '.$val;
        }
        
        // return clause
        return "WHERE ".implode(' '.(string)$operator.' ', $clauses);
    }
}