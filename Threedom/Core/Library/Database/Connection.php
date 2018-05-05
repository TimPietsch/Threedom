<?php
namespace Threedom\Library\Database;

/**
 * Description of Database
 *
 * @deprecated?
 * @version 0.0.1b
 * @author Beef
 */
class Connection {
    /* PUBLIC */
    
    /**
     * The database connection
     * 
     * @var mysqli
     */
    public $connection;
    
    public function __construct($name = null) {
        
    }
    
    public function open() {
        
    }
    
    public function connected() {
        
    }
    
    public function __destruct() {
        $this->connection->close();
    }
    
    /* PRIVATE */
    
    /* database configuration */
    private $_host = DATABASE_HOST;
    private $_user = DATABASE_USER;
    private $_pass = DATABASE_PASS;
    private $_name = DATABASE_NAME;
    
}
