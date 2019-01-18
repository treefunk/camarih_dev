<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_rates_Table extends CI_Migration {

        public function up()
        {
                $this->dbforge->add_field(array(
                        'id' => array(
                                'type' => 'INT',
                                'constraint' => '100',
                                'unsigned' => TRUE,
                                'auto_increment' => TRUE
                        ),
                        'trip_availability_id' => array(
                            'type' => 'INT',
                            'constraint' => '100',
                            'unsigned' => TRUE,
                        ),
                        'destination_id' => array(
                            'type' => 'INT',
                            'constraint' => '100',
                            'unsigned' => TRUE
                        ),
                        'price' => array(
                            'type' => 'DOUBLE',
                        )
                ));

                $this->dbforge->add_field("`created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP");
                $this->dbforge->add_key('id', TRUE);
                $this->dbforge->create_table('rates');
        }

        public function down()
        {
                $this->dbforge->drop_table('rates');
        }
}