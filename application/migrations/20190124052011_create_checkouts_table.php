<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_checkouts_Table extends CI_Migration {

        public function up()
        {
                $this->dbforge->add_field(array(
                        'id' => array(
                                'type' => 'INT',
                                'constraint' => '255',
                                'unsigned' => TRUE,
                                'auto_increment' => TRUE
                        ),
                        'fullname' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '255',
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
                $this->dbforge->create_table('checkouts');
        }

        public function down()
        {
                $this->dbforge->drop_table('checkouts');
        }
}