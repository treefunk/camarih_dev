<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_package_details_Table extends CI_Migration {

        public function up()
        {
                $this->dbforge->add_field(array(
                        'id' => array(
                                'type' => 'INT',
                                'constraint' => '100',
                                'unsigned' => TRUE,
                                'auto_increment' => TRUE
                        ),
                        'package_id' => array(
                            'type' => 'INT',
                            'constraint' => '100',
                            'unsigned' => TRUE,
                        ),
                        'minimum_count' => array(
                                'type' => 'INT',
                                'null' => TRUE
                        ),
                        'description' => array(
                                'type' => 'LONGTEXT'
                        ),
                        'exclusions' => array(
                                'type' => 'LONGTEXT'
                        ),
                        'inclusions' => array(
                                'type' => 'LONGTEXT'
                        ),
                        'price_description' => array(
                                'type' => 'LONGTEXT'
                        )
                ));

                $this->dbforge->add_field("`created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP");
                $this->dbforge->add_key('id', TRUE);
                $this->dbforge->create_table('package_details',TRUE,['ENGINE' => 'InnoDB']);
        }

        public function down()
        {
                $this->dbforge->drop_table('package_details');
        }
}