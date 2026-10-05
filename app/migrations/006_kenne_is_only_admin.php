<?php

class kenne_is_only_admin
{
    private $_lava;

    public function __construct()
    {
        $this->_lava = lava_instance();
        $this->_lava->call->dbforge();
    }

    public function up()
    {
        foreach (['users', 'api_users'] as $table) {
            if (!$this->_lava->dbforge->table_exists($table)) {
                throw new RuntimeException(
                    "The {$table} table is required to assign the product administrator."
                );
            }

            $kenne_count = (int) $this->_lava->db->raw(
                "SELECT COUNT(*) FROM {$table} WHERE LOWER(username) = ?",
                ['kenne']
            )->fetchColumn();
            if ($kenne_count !== 1) {
                throw new RuntimeException(
                    "Expected exactly one kenne account in {$table}; resolve the account data before migrating."
                );
            }
        }

        $matching_accounts = (int) $this->_lava->db->raw(
            'SELECT COUNT(*)
             FROM users AS source
             INNER JOIN api_users AS target ON target.id = source.id
             WHERE LOWER(source.username) = ?
               AND LOWER(target.username) = ?
               AND source.email <=> target.email
               AND source.password <=> target.password
               AND source.is_active <=> target.is_active',
            ['kenne', 'kenne']
        )->fetchColumn();
        if ($matching_accounts !== 1) {
            throw new RuntimeException(
                'The kenne accounts in users and api_users do not match; resolve the account data before migrating.'
            );
        }

        foreach (['users', 'api_users'] as $table) {
            $this->_lava->db->raw(
                "UPDATE {$table}
                 SET role = CASE WHEN LOWER(username) = ? THEN 'admin' ELSE 'user' END",
                ['kenne']
            );
        }
    }

    public function down()
    {
        foreach (['users', 'api_users'] as $table) {
            if ($this->_lava->dbforge->table_exists($table)) {
                $this->_lava->db->raw(
                    "UPDATE {$table} SET role = 'user' WHERE LOWER(username) = ?",
                    ['kenne']
                );
            }
        }
    }
}
