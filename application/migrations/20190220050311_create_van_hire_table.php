<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_van_hire_Table extends CI_Migration {

        public function up()
        {
                $this->dbforge->add_field(array(
                        'id' => array(
                                'type' => 'INT',
                                'constraint' => '100',
                                'unsigned' => TRUE,
                                'auto_increment' => TRUE
                        ),
                        'checkout_id' => array(
                            'type' => 'INT',
                            'constraint' => '255',
                            'unsigned' => TRUE
                        ),
                        'van_id' => array(
                            'type' => 'INT',
                            'constraint' => '255',
                            'unsigned' => TRUE
                        ),
                        'origin_id' => array(
                            'type' => 'INT',
                            'constraint' => '255',
                            'unsigned' => TRUE
                        ),
                        'destination_id' => array(
                            'type' => 'INT',
                            'constraint' => '255',
                            'unsigned' => TRUE
                        ),
                        'rent_date'=> array(
                            'type' => 'DATETIME'
                        ),
                ));

                $this->dbforge->add_field("`created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP");
                $this->dbforge->add_key('id', TRUE);
                $this->dbforge->create_table('van_hire');
        }

        public function down()
        {
                $this->dbforge->drop_table('van_hire');
        }
}