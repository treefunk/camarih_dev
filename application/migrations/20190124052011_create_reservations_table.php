<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_reservations_Table extends CI_Migration {

        public function up()
        {
                $this->dbforge->add_field(array(
                        'id' => array(
                                'type' => 'INT',
                                'constraint' => '255',
                                'unsigned' => TRUE,
                                'auto_increment' => TRUE
                        ),
                        'full_name' => array(
                            'type' => 'LONGTEXT',
                            'null' => TRUE
                        ),
                        'email' => array(
                            'type' => 'VARCHAR',
                            'constraint' => '255',
                            'null' => TRUE
                        ),
                        'phone' => array(
                            'type' => 'VARCHAR',
                            'constraint' => '255',
                            'null' => TRUE
                        ),
                        'pickup_location' => array(
                            'type' => 'LONGTEXT',
                            'null' => TRUE
                        ),
                        'drop_location' => array(
                            'type' => 'LONGTEXT',
                            'null' => TRUE
                        ),
                        'status' => array(
                            'type' => 'VARCHAR',
                            'constraint' => '200',
                            'default' => 'pending',
                        ),
                        'active' => array(
                            'type' => 'TINYINT',
                            'constraint' => '10',
                            'default' => 1
                        )
                ));

                $this->dbforge->add_field("`created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP");
                $this->dbforge->add_key('id', TRUE);
                $this->dbforge->create_table('reservations');
        }

        public function down()
        {
                $this->dbforge->drop_table('reservations');
        }
}