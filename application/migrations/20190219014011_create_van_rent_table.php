<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_van_rent_Table extends CI_Migration {

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
                                'constraint' => '100',
                                'unsigned' => TRUE
                        ),
                        'departure_date' => array(
                                'type' => 'datetime'
                        ),
                        'trip_type' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '255',
                                'comment' => 'oneway_rate, roundtrip_rate'
                        ),
                        'origin_id' => array(
                                'type' => 'INT',
                                'constraint' => '100',
                                'unsigned' => TRUE,
                                'comment' => 'destination ID'
                        ),
                        'destination_id' => array(
                                'type' => 'INT',
                                'constraint' => '100',
                                'unsigned' => TRUE,
                                'comment' => 'destination ID'
                        ),
                        'adult_count' => array(
                                'type' => 'INT',
                                'constraint' => '255',
                                'unsigned' => TRUE
                        ),
                        'price' => array(
                                'type' => 'DOUBLE',
                        ),
                        'status' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '200',
                                'default' => 'reserved'
                        ),
    
                ));

                $this->dbforge->add_field("`created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP");
                $this->dbforge->add_key('id', TRUE);
                $this->dbforge->create_table('van_rent',TRUE,['ENGINE' => 'InnoDB']);
        }

        public function down()
        {
                $this->dbforge->drop_table('van_rent');
        }
}