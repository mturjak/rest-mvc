<?php

class UserModel {

    /**
     * Constructor, expects a Database connection
     * @param Database $db The Database object
     */
    public function __construct(Database $db)
    {
        $this->db = $db;
    }

	/**
     * Session token renewer
     */
	public function renew() {
		// dummy
		return true;
	}
}