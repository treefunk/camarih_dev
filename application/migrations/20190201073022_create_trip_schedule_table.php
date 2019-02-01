<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_trip_schedule_Table extends CI_Migration {
        public function up()
        {
                $this->dbforge->add_field(array(
                        'id' => array(
                                'type' => 'INT',
                                'constraint' => '255',
                                'unsigned' => TRUE,
                                'auto_increment' => TRUE
                        ),
                        'departure_time' => array(
                            'type' => 'VARCHAR',
                            'constraint' => '255',
                            'null' => TRUE
                        ),
                        'type' => array(
                            'type' => 'tinyint',
                            'constraint' => 5,
                            'comment' => '1 = PPS - ELN, 2 = ELN - PPS'
                        )
                ));

                $this->dbforge->add_field("`created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP");
                $this->dbforge->add_key('id', TRUE);
                $this->dbforge->create_table('trip_schedule');
        }

        public function down()
        {
                $this->dbforge->drop_table('trip_schedule');
        }
}