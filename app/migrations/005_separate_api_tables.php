<?php

class separate_api_tables
{
    private $_lava;

    public function __construct()
    {
        $this->_lava = lava_instance();
        $this->_lava->call->dbforge();
    }

    public function up()
    {
        if (!$this->_lava->dbforge->table_exists('users')
            || !$this->_lava->dbforge->table_exists('products')) {
            throw new RuntimeException(
                'The existing users and products tables are required before separating API data.'
            );
        }

        if (!$this->_lava->dbforge->table_exists('api_users')) {
            $this->_lava->dbforge
                ->add_field([
                    'id' => [
                        'type'           => 'INT',
                        'constraint'     => 11,
                        'unsigned'       => TRUE,
                        'auto_increment' => TRUE,
                        'null'           => FALSE,
                    ],
                    'username' => [
                        'type'       => 'VARCHAR',
                        'constraint' => 100,
                        'null'       => FALSE,
                    ],
                    'email' => [
                        'type'       => 'VARCHAR',
                        'constraint' => 255,
                        'null'       => FALSE,
                    ],
                    'password' => [
                        'type'       => 'VARCHAR',
                        'constraint' => 255,
                        'null'       => FALSE,
                    ],
                    'role' => [
                        'type'       => 'ENUM',
                        'constraint' => "'admin','moderator','user'",
                        'null'       => FALSE,
                        'default'    => 'user',
                    ],
                    'is_active' => [
                        'type'       => 'TINYINT',
                        'constraint' => 1,
                        'unsigned'   => TRUE,
                        'null'       => FALSE,
                        'default'    => 1,
                    ],
                    'created_at' => [
                        'type'    => 'DATETIME',
                        'null'    => FALSE,
                        'default' => 'CURRENT_TIMESTAMP',
                    ],
                    'updated_at' => [
                        'type'    => 'DATETIME',
                        'null'    => TRUE,
                        'default' => NULL,
                    ],
                ])
                ->add_key('id', primary: TRUE)
                ->add_key('username', unique: TRUE, name: 'api_username_unique')
                ->add_key('email', unique: TRUE, name: 'api_email_unique')
                ->add_key('role', name: 'api_role_idx')
                ->create_table('api_users');
        }

        if (!$this->_lava->dbforge->table_exists('api_products')) {
            $this->_lava->dbforge
                ->add_field([
                    'id' => [
                        'type'           => 'INT',
                        'constraint'     => 11,
                        'unsigned'       => TRUE,
                        'auto_increment' => TRUE,
                        'null'           => FALSE,
                    ],
                    'product_name' => [
                        'type'       => 'VARCHAR',
                        'constraint' => 100,
                        'null'       => FALSE,
                    ],
                    'description' => [
                        'type' => 'TEXT',
                        'null' => TRUE,
                    ],
                    'price' => [
                        'type'       => 'DECIMAL',
                        'constraint' => '10,2',
                        'null'       => FALSE,
                    ],
                    'quantity' => [
                        'type'       => 'INT',
                        'constraint' => 11,
                        'unsigned'   => TRUE,
                        'null'       => FALSE,
                        'default'    => 0,
                    ],
                    'created_at' => [
                        'type'    => 'TIMESTAMP',
                        'null'    => FALSE,
                        'default' => 'CURRENT_TIMESTAMP',
                    ],
                ])
                ->add_key('id', primary: TRUE)
                ->create_table('api_products');
        }

        $this->_lava->db->raw(
            'INSERT IGNORE INTO api_users
                (id, username, email, password, role, is_active, created_at, updated_at)
             SELECT id, username, email, password, role, is_active, created_at, updated_at
             FROM users'
        );

        $unmatched_users = (int) $this->_lava->db->raw(
            'SELECT COUNT(*) FROM users source
             LEFT JOIN api_users target ON target.id = source.id
             WHERE target.id IS NULL
                OR NOT (
                    target.username <=> source.username
                    AND target.email <=> source.email
                    AND target.password <=> source.password
                    AND target.role <=> source.role
                    AND target.is_active <=> source.is_active
                    AND target.created_at <=> source.created_at
                    AND target.updated_at <=> source.updated_at
                )'
        )->fetchColumn();
        if ($unmatched_users > 0) {
            throw new RuntimeException(
                'Could not copy every user to api_users without conflicts. Resolve duplicate user data and rerun the migration.'
            );
        }

        $this->_lava->db->raw(
            'INSERT IGNORE INTO api_products
                (id, product_name, description, price, quantity, created_at)
             SELECT id, product_name, description, price, quantity, created_at
             FROM products'
        );

        $unmatched_products = (int) $this->_lava->db->raw(
            'SELECT COUNT(*) FROM products source
             LEFT JOIN api_products target ON target.id = source.id
             WHERE target.id IS NULL
                OR NOT (
                    target.product_name <=> source.product_name
                    AND target.description <=> source.description
                    AND target.price <=> source.price
                    AND target.quantity <=> source.quantity
                    AND target.created_at <=> source.created_at
                )'
        )->fetchColumn();
        if ($unmatched_products > 0) {
            throw new RuntimeException(
                'Could not copy every product to api_products without conflicts. Resolve duplicate product data and rerun the migration.'
            );
        }
    }

    public function down()
    {
        $this->_lava->dbforge->drop_table('api_products');
        $this->_lava->dbforge->drop_table('api_users');
    }
}
