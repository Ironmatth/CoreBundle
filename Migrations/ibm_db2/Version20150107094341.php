<?php

namespace Claroline\CoreBundle\Migrations\ibm_db2;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated migration based on mapping information: modify it with caution
 *
 * Generation date: 2015/01/07 09:43:42
 */
class Version20150107094341 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("
            CREATE TABLE claro_personnal_workspace_tool_config (
                id INTEGER GENERATED BY DEFAULT AS IDENTITY NOT NULL, 
                role_id INTEGER NOT NULL, 
                tool_id INTEGER NOT NULL, 
                mask INTEGER NOT NULL, 
                PRIMARY KEY(id)
            )
        ");
        $this->addSql("
            CREATE INDEX IDX_7A4A6A64D60322AC ON claro_personnal_workspace_tool_config (role_id)
        ");
        $this->addSql("
            CREATE INDEX IDX_7A4A6A648F7B22CC ON claro_personnal_workspace_tool_config (tool_id)
        ");
        $this->addSql("
            CREATE UNIQUE INDEX pws_unique_tool_config ON claro_personnal_workspace_tool_config (tool_id, role_id)
        ");
        $this->addSql("
            CREATE TABLE claro_personal_workspace_resource_rights_management_access (
                id INTEGER GENERATED BY DEFAULT AS IDENTITY NOT NULL, 
                role_id INTEGER NOT NULL, 
                is_accessible SMALLINT NOT NULL, 
                PRIMARY KEY(id)
            )
        ");
        $this->addSql("
            CREATE INDEX IDX_A3AE069AD60322AC ON claro_personal_workspace_resource_rights_management_access (role_id)
        ");
        $this->addSql("
            ALTER TABLE claro_personnal_workspace_tool_config 
            ADD CONSTRAINT FK_7A4A6A64D60322AC FOREIGN KEY (role_id) 
            REFERENCES claro_role (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE claro_personnal_workspace_tool_config 
            ADD CONSTRAINT FK_7A4A6A648F7B22CC FOREIGN KEY (tool_id) 
            REFERENCES claro_tools (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE claro_personal_workspace_resource_rights_management_access 
            ADD CONSTRAINT FK_A3AE069AD60322AC FOREIGN KEY (role_id) 
            REFERENCES claro_role (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            CREATE INDEX IDX_EB8D285282D40A1F ON claro_user (workspace_id)
        ");
        $this->addSql("
            CREATE INDEX IDX_A76799FFAA23F6C8 ON claro_resource_node (next_id)
        ");
        $this->addSql("
            CREATE INDEX IDX_A76799FF2DE62210 ON claro_resource_node (previous_id)
        ");
        $this->addSql("
            ALTER TABLE claro_workspace 
            ADD COLUMN maxStorageSize VARCHAR(255) NOT NULL WITH DEFAULT 
            ADD COLUMN maxUploadResources INTEGER NOT NULL WITH DEFAULT 
            ADD COLUMN is_personal SMALLINT NOT NULL WITH DEFAULT
        ");
        $this->addSql("
            CREATE INDEX IDX_5E7F4AB8B87FAB32 ON claro_resource_shortcut (resourceNode_id)
        ");
        $this->addSql("
            ALTER TABLE claro_directory 
            ADD COLUMN is_upload_destination SMALLINT NOT NULL WITH DEFAULT
        ");
        $this->addSql("
            CREATE INDEX IDX_12EEC186B87FAB32 ON claro_directory (resourceNode_id)
        ");
        $this->addSql("
            CREATE INDEX IDX_E2EE25E281C06096 ON claro_activity_parameters (activity_id)
        ");
        $this->addSql("
            CREATE INDEX IDX_EA81C80BB87FAB32 ON claro_file (resourceNode_id)
        ");
        $this->addSql("
            CREATE INDEX IDX_5D9559DCB87FAB32 ON claro_text (resourceNode_id)
        ");
        $this->addSql("
            CREATE INDEX IDX_E4A67CAC88BD9C1F ON claro_activity (parameters_id)
        ");
        $this->addSql("
            CREATE INDEX IDX_E4A67CACB87FAB32 ON claro_activity (resourceNode_id)
        ");
    }

    public function down(Schema $schema)
    {
        $this->addSql("
            DROP TABLE claro_personnal_workspace_tool_config
        ");
        $this->addSql("
            DROP TABLE claro_personal_workspace_resource_rights_management_access
        ");
        $this->addSql("
            DROP INDEX IDX_E4A67CAC88BD9C1F
        ");
        $this->addSql("
            DROP INDEX IDX_E4A67CACB87FAB32
        ");
        $this->addSql("
            DROP INDEX IDX_E2EE25E281C06096
        ");
        $this->addSql("
            DROP INDEX IDX_12EEC186B87FAB32
        ");
        $this->addSql("
            ALTER TABLE claro_directory 
            DROP COLUMN is_upload_destination
        ");
        $this->addSql("
            CALL SYSPROC.ADMIN_CMD ('REORG TABLE claro_directory')
        ");
        $this->addSql("
            DROP INDEX IDX_EA81C80BB87FAB32
        ");
        $this->addSql("
            DROP INDEX IDX_A76799FFAA23F6C8
        ");
        $this->addSql("
            DROP INDEX IDX_A76799FF2DE62210
        ");
        $this->addSql("
            DROP INDEX IDX_5E7F4AB8B87FAB32
        ");
        $this->addSql("
            DROP INDEX IDX_5D9559DCB87FAB32
        ");
        $this->addSql("
            DROP INDEX IDX_EB8D285282D40A1F
        ");
        $this->addSql("
            ALTER TABLE claro_workspace 
            DROP COLUMN maxStorageSize 
            DROP COLUMN maxUploadResources 
            DROP COLUMN is_personal
        ");
        $this->addSql("
            CALL SYSPROC.ADMIN_CMD ('REORG TABLE claro_workspace')
        ");
    }
}