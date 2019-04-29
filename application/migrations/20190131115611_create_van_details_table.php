<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_van_details_Table extends CI_Migration {

        public function up()
        {
                $this->dbforge->add_field(array(
                        'id' => array(
                                'type' => 'INT',
                                'constraint' => '255',
                                'unsigned' => TRUE,
                                'auto_increment' => TRUE
                        ),
                        'van_id' => array(
                            'type' => 'INT',
                            'constraint' => '255',
                            'unsigned' => TRUE
                        ),
                        'oneway_rate' => array(
                            'type' => 'DOUBLE',
                            'null' => TRUE
                        ),
                        'roundtrip_rate' => array(
                            'type' => 'DOUBLE',
                            'null' => TRUE
                        )
                ));

                $this->dbforge->add_field("`created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP");
                $this->dbforge->add_key('id', TRUE);
                $this->dbforge->create_table('van_details',TRUE,['ENGINE' => 'InnoDB']);
        }

        public function down()
        {
                $this->dbforge->drop_table('van_details');
        }
}