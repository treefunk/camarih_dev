<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_trip_availability_Table extends CI_Migration {

        public function up()
        {
                $this->dbforge->add_field(array(
                        'id' => array(
                                'type' => 'INT',
                                'constraint' => '100',
                                'unsigned' => TRUE,
                                'auto_increment' => TRUE
                        ),
                        'van_id' => array(
                            'type' => 'INT',
                            'constraint' => '100',
                            'unsigned' => TRUE
                        ),
                        'destination_from' => array(
                            'type' => 'INT',
                            'constraint' => '100',
                            'unsigned' => TRUE,
                            'comment' => 'destination ID'
                        ),
                        'selling_start' => array(
                            'type' => 'datetime'
                        ),
                        'selling_end' => array(
                            'type' => 'datetime'
                        )
                ));

                $this->dbforge->add_field("`created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP");
                $this->dbforge->add_key('id', TRUE);
                $this->dbforge->create_table('trip_availability',TRUE,['ENGINE' => 'InnoDB']);
        }

        public function down()
        {
                $this->dbforge->drop_table('trip_availability');
        }
}