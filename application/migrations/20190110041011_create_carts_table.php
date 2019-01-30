<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_carts_Table extends CI_Migration {

        public function up()
        {
                $this->dbforge->add_field(array(
                        'id' => array(
                                'type' => 'INT',
                                'constraint' => '255',
                                'unsigned' => TRUE,
                                'auto_increment' => TRUE
                        ),
                        'name' => array(
                            'type' => 'LONGTEXT',
                            'null' => TRUE
                        ),
                        'reservation_id' => array(
                            'type' => 'INT',
                            'constraint' => '255',
                            'unsigned' => TRUE
                        ),
                        'rate_id' => array(
                            'type' => 'INT',
                            'constraint' => '255',
                            'unsigned' => TRUE
                        ),
                        'departure_date' => array(
                            'type' => 'datetime'
                        ),
                        'package_id' => array(
                            'type' => 'INT',
                            'constraint' => '255',
                            'unsigned' => TRUE,
                            'null' => TRUE
                        ),
                        'status' => array(
                            'type' => 'VARCHAR',
                            'constraint' => '200',
                            'default' => 'pending'
                        ),
                        'active' => array(
                            'type' => 'TINYINT',
                            'constraint' => '10',
                            'default' => 1
                        )
                ));

                $this->dbforge->add_field("`created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP");
                $this->dbforge->add_key('id', TRUE);
                $this->dbforge->create_table('carts');
        }

        public function down()
        {
                $this->dbforge->drop_table('carts');
        }
}