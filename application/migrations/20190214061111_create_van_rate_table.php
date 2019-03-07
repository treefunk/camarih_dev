<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_van_rate_Table extends CI_Migration {

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
                        'oneway_rate' => array(
                            'type' => 'LONGTEXT'
                        ),
                        'roundtrip_rate' => array(
                            'type' => 'LONGTEXT'
                        )
                ));

                $this->dbforge->add_field("`created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP");
                $this->dbforge->add_key('id', TRUE);
                $this->dbforge->create_table('van_rate');
        }

        public function down()
        {
                $this->dbforge->drop_table('van_rate');
        }
}