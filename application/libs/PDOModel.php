<?php
/* base PDO model class */
class PDOModel {

    /**
     * @Inject
     * @var Database
     */
    private $db;

    /**
     * Constructor, expects a Database connection
     * @param Database $db The Database object
     */
    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    
}