<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_footer_details_Table extends CI_Migration {
        public function up()
        {
                $this->dbforge->add_field(array(
                        'id' => array(
                                'type' => 'INT',
                                'constraint' => '255',
                                'unsigned' => TRUE,
                                'auto_increment' => TRUE
                        ),
                        'type' => array(
                            'type' => 'VARCHAR',
                            'constraint' => '255',
                        ),
                        'value' => array(
                            'type' => 'LONGTEXT',
                            'null' => TRUE
                        )
                ));

                $this->dbforge->add_field("`created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP");
                $this->dbforge->add_key('id', TRUE);
                $this->dbforge->create_table('footer_details',TRUE,['ENGINE' => 'InnoDB']);
        }

        public function down()
        {
                $this->dbforge->drop_table('footer_details');
        }
}