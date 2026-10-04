<?php

class Products_api_schema
{
    private $_lava;

    public function __construct()
    {
        $this->_lava = lava_instance();
        $this->_lava->call->dbforge();
    }

    public function up()
    {
        if (!$this->_lava->dbforge->table_exists('products')) {
            throw new RuntimeException('The products table must exist before applying this migration.');
        }

        $long_names = $this->_lava->db->raw(
            'SELECT COUNT(*) FROM products WHERE CHAR_LENGTH(product_name) > 100'
        )->fetchColumn();
        if ((int) $long_names > 0) {
            throw new RuntimeException(
                'Cannot limit products.product_name to 100 characters: existing rows exceed that length.'
            );
        }

        $this->_lava->dbforge->modify_column('products', [
            'product_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => FALSE,
            ],
        ]);

        if (!$this->_lava->dbforge->column_exists('products', 'created_at')) {
            $this->_lava->dbforge->add_column('products', [
                'created_at' => [
                    'type'    => 'TIMESTAMP',
                    'null'    => FALSE,
                    'default' => 'CURRENT_TIMESTAMP',
                ],
            ]);
        }
    }

    public function down()
    {
        if (!$this->_lava->dbforge->table_exists('products')) {
            return;
        }

        if ($this->_lava->dbforge->column_exists('products', 'created_at')) {
            $this->_lava->dbforge->drop_column('products', 'created_at');
        }

        if ($this->_lava->dbforge->column_exists('products', 'product_name')) {
            $this->_lava->dbforge->modify_column('products', [
                'product_name' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => FALSE,
                ],
            ]);
        }
    }
}
